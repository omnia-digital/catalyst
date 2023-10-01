<?php

namespace Modules\Livestream\Http\Controllers;

use Carbon\Carbon;
use Exception;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use HttpInvalidParamException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livestream\Livestream;
use Modules\Livestream\Actions\CreateNewEpisodeFromUploadedVideo;
use Modules\Livestream\Episode;
use Modules\Livestream\EpisodeDownload;
use Modules\Livestream\Events\Stream\StreamEnded;
use Modules\Livestream\Events\Stream\StreamStarted;
use Modules\Livestream\Exceptions\LivestreamAccountIdNotFoundException;
use Modules\Livestream\Http\Requests\EpisodeEditRequest;
use Modules\Livestream\Http\Requests\EpisodeImportRequest;
use Modules\Livestream\Http\Requests\EpisodeIndexRequest;
use Modules\Livestream\Http\Requests\EpisodeRequest;
use Modules\Livestream\Http\Requests\LivestreamRequest;
use Modules\Livestream\Http\Requests\Notifications\StreamEndNotificationRequest;
use Modules\Livestream\Http\Requests\Notifications\StreamStartNotificationRequest;
use Modules\Livestream\Interactions\DeleteEpisodeThumbnail;
use Modules\Livestream\Interactions\UpdateEpisodeThumbnail;
use Modules\Livestream\Jobs\Episode\DownloadEpisodes;
use Modules\Livestream\LivestreamAccount;
use Modules\Livestream\Omnia;
use Modules\Livestream\Repositories\EpisodeRepository;
use Modules\Livestream\Repositories\VideoRepository;
use Modules\Livestream\Services\EpisodeImportService;
use Modules\Livestream\Services\EpisodeService;
use Modules\Livestream\Services\MuxService;
use Modules\Livestream\SocialAccount;
use Modules\Livestream\Video;
use MuxPhp\ApiException;

class EpisodeController extends LivestreamController
{
    /**
     * Set the default total of episodes should be showed per page.
     *
     * @var int
     */
    private $show = 15;

    /**
     * Display a listing of the resource.
     *
     *
     * @return Response
     *
     * @throws Exception
     */
    public function index(EpisodeIndexRequest $request)
    {
        $timezone = null;
        $livestreamAccount = null;
        if (! empty($request->timezone)) {
            $timezone = $request->timezone;
        }

        if (empty($this->_livestreamAccount)) {
            throw new AuthenticationException('Could not find a livestreamAccount');
        }

        return Omnia::interact(EpisodeRepository::class . '@all', [$timezone]);
    }

    /**
     * Search for Episodes
     *
     *
     * @return mixed
     *
     * @throws HttpInvalidParamException
     */
    public function search(EpisodeIndexRequest $request, $published = null)
    {
        $timezone = null;
        $livestreamAccount = null;
        if (! empty($request->timezone)) {
            $timezone = $request->timezone;
        }

        if ($request->has('livestream_account_id')) {
            $livestreamAccount = Livestream::getLivestreamAccount($request->get('livestream_account_id'));
        } else {
            if (! empty($this->_livestreamAccount)) {
                $livestreamAccount = $this->_livestreamAccount;
            } else {
                throw new LivestreamAccountIdNotFoundException;
            }
        }

        return Omnia::interact(EpisodeRepository::class . '@all', [
            $timezone,
            $livestreamAccount,
            $published,
            true,
            $request->show ?? $this->show,
            $request->currentPage ?? 1,
            $request->get('query'),
        ]);
    }

    /**
     * Return the most recent Episode for this livestreamAccount
     */
    public function mostRecentEpisode()
    {
        return Episode::where('livestream_account_id', $this->_livestreamAccount->id)->orderBy('date_recorded',
            'desc')->first();
    }

    /**
     * Return the URL for the Episode that is currently Live
     */
    public function getLiveEpisode()
    {
    }

    /**
     * Store a newly created Episode in storage.
     *
     * @param  EpisodeRequest|Request  $request
     * @return JsonResponse
     */
    public function store(EpisodeEditRequest $request)
    {
        DB::beginTransaction();

        $params = $request->all();
        $params['title'] = $request->get('title');
        $params['description'] = $request->get('description');
        $params['livestream_account_id'] = $this->_livestreamAccount->id;

        // check for a timezone in the payload. If that doesn't exist, use the default Team timezone
        $timezone = Omnia::getTimezone($request->get('timezone'), $this->_livestreamAccount->team);

        // Date Recorded
        if ($request->filled('date_recorded')) {
            $date_recorded = $request->get('date_recorded');
            if (! is_numeric($date_recorded)) {
                $carbonTime = new Carbon($date_recorded, $timezone);
                $date_recorded = $carbonTime->setTimezone(config('app.timezone'));
            }

            //  timestamp of $date_recorded
            $params['date_recorded'] = $date_recorded;
        }
        // Planned Start Time
        if ($request->filled('planned_start_time')) {
            $planned_start_time = $request->get('planned_start_time');
            // If it's numeric, then we will assume it's a timestamp (UTC)
            if (! is_numeric($planned_start_time)) {
                $carbonTime = new Carbon($planned_start_time, $timezone);
                $planned_start_time = $carbonTime->setTimezone(config('app.timezone'))->timestamp;
            }

            //  timestamp of planned_start_time
            $params['planned_start_time'] = $planned_start_time;
        }
        if ($request->filled('mux_asset_id')) {
            $params['mux_asset_id'] = $request->get('mux_asset_id');
        }

        // Create Episode
        $episode = Episode::create($params);

        if (! empty($episode->mux_asset_id)) {
            $video = Omnia::interact(VideoRepository::class . '@create', [$episode]);
        }

        DB::commit();

        return response()->json([
            'success' => true,
            'data' => $episode,
        ]);
    }

    /**
     * Update the Episode
     *
     *
     * @return Response
     *
     * @throws FacebookResponseException
     * @throws FacebookSDKException
     */
    public function update(EpisodeEditRequest $request, Episode $episode)
    {
        $episodeData = $request->all();

        $timezone = Omnia::getTimezone($request->get('timezone'), $episode->livestreamAccount->team);

        // Date Recorded
        if ($request->filled('date_recorded')) {
            $date_recorded = $request->get('date_recorded');
            if (! is_numeric($date_recorded)) {
                $carbonTime = new Carbon($date_recorded, $timezone);
                $date_recorded = $carbonTime->setTimezone(config('app.timezone'));
            }

            //  timestamp of $date_recorded
            $episodeData['date_recorded'] = $date_recorded;
        }

        if ($request->has('videos')) {
            // @TODO [Josh] - later
            // we should only be sending data we want to update, so if there are any videos, we assume they are new
            // create a new video
            // associate video with this episode
        }

        // NOTE: It is bad user experience to be able to update thumbnail details because they may not know that they are changing the root image information. So we will only allow creation here
        //. We need to offer them a link to change the root image info, OR copy it to a new image in order to update specifically for this episode. But we should never allow an update to an Image through this service;
        // I have simplified the thumbnail/image process for now to simply be a path on the column thumbnail on the episode table
        //        if ($episodeData->has('thumbnail') && !empty($episodeData->get('thumbnail'))) {
        //            $thumbnail = $request->file('thumbnail');
        //            $thumbnail2 = $episodeData->get('thumbnail');
        //            $episodeData->put('thumbnail_image_id', $thumbnail['id']);
        //            $episodeData->forget('thumbnail');
        //        } else if (!empty($episode->thumbnail_image_id)) {
        ////            $thumbnail_id = $episode->thumbnail_image_id;
        //            $episode->thumbnail_image_id = null;
        //            $episode->save();
        //            // we don't want to delete the image because it may be associated with other episodes
        ////            $imageService = new ImageService();
        ////            $imageService->deleteImage($thumbnail_id);
        //        }

        //        if ($episodeData->has('selected_people')) {
        //            foreach($episodeData->get('selected_people') as $person_id) {
        //                $episode->people()->sync($person_id);
        //            }
        //            $episodeData->forget('selected_people');
        //        } else {
        //            // Detach all people from this Episode if none are passed in
        //            $episode->people()->detach();
        //        }
        //
        //        if ($episodeData->has('main_speaker') && !empty($episodeData->get('main_speaker'))) {
        //            $episodeData->put('main_speaker_id',$episodeData->get('main_speaker'));
        //        }

        // If updating planned_start_time, we need to update all of the videos on facebook
        // Planned Start Time
        if ($request->filled('planned_start_time')) {
            $planned_start_time = $request->get('planned_start_time');

            // If it's numeric, then we will assume it's a timestamp (UTC)
            if (! is_numeric($planned_start_time)) {
                $carbonTime = new Carbon($planned_start_time, $timezone);
                $planned_start_time = $carbonTime->setTimezone(config('app.timezone'))->timestamp;
            }

            // Update the Episode with the timestamp of planned_start_time
            $episodeData['planned_start_time'] = $planned_start_time;

            // Remove this section because we aren't using the 'planned_start_time' param on facebook since it creates the 'this page plans to go live post'
            // @TODO [Josh] - we may add this as a feature in the future so a page can post that if they want.
            //                $videos = $episode->videos;
            //                foreach ($videos as $video) {
            //
            //                    $fbLiveVideoParams = [
            //                        'video_id'           => $video->video_source_id,
            //                        'planned_start_time' => $planned_start_time
            //                    ];
            //
            //                    $user                  = Auth::user();
            //                    $socialAccounts        = SocialAccount::whereUserId($user->id)->where('provider', '=', 'facebook')->get();
            //                    $facebookSocialAccount = $socialAccounts->first();
            //
            //                    // Grab all facebook pages that the user has admin access to
            //                    $socialAccountService    = new SocialAccountService($facebookSocialAccount);
            //                    $all_user_facebook_pages = collect($socialAccountService->getFacebookPages());
            //
            //                    $fb_page = $video->video_source_account_id;
            //                    // find if fb_page is in user facebook pages
            //                    if ( ! empty($fb_page)) {
            //                        $found_fb_page = $all_user_facebook_pages->first(function ($item, $key) use ($fb_page) {
            //                            return $item['id'] == $fb_page;
            //                        });
            //
            //                        if ( ! empty($found_fb_page)) {
            //                            $teamObject = [
            //                                'id'           => $found_fb_page['id'],
            //                                'access_token' => $found_fb_page['access_token']
            //                            ];
            //
            //                            $streamTargetService = new StreamIntegrationService($this->_livestreamAccount);
            //                            $fbVideoResponse     = $streamTargetService->updateFacebookLiveVideo($fbLiveVideoParams, $teamObject);
            //                        }
            //                    }
            //                }
        }

        foreach ($episodeData as $key => $data) {
            if (is_array($data)) {
                unset($episodeData[$key]);
            }
        }

        $episode->update($episodeData);

        return $this->show($episode);
    }

    /**
     * Return one Episode
     *
     *
     * @return Response
     */
    public function show(Episode $episode)
    {
        return Omnia::interact(EpisodeRepository::class . '@get', [$episode]);
    }

    /**
     * Remove the Episode and move associated video files from storage.
     *
     * @param  bool  $deleteVideos
     * @return Response
     */
    public function destroy(Episode $episode, $deleteVideos = true)
    {
        $episodeService = new EpisodeService($this->_livestreamAccount);
        $count = $episodeService->deleteEpisode($episode, $deleteVideos);
        flash('Episode deleted: ' . $count);

        return response()->json($count);
    }

    /**
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function deleteAll($deleteVideos = true)
    {
        try {
            $episodes = $this->_livestreamAccount->episodes;
            $count = 0;
            foreach ($episodes as $episode) {
                $episodeService = new EpisodeService($this->_livestreamAccount);
                $success = $episodeService->deleteEpisode($episode, $deleteVideos);
                if ($success) {
                    $count++;
                }
            }

            return response()->json([
                'success' => true,
                'Episodes Deleted' => $count,
            ]);
        } catch (Exception $e) {
            throw new Exception('Couldn\'t finish process: ' . __FUNCTION__ . ': ' . $e->getMessage());
        }
    }

    /**
     * Stream Start Notification
     * API Method
     *
     *
     * @return Response
     *
     * @throws Exception
     */
    public function streamStart(StreamStartNotificationRequest $notificationRequest)
    {
        try {
            Log::info(__CLASS__ . ': [START - Stream Start]');
            $notificationRequest->validateAll();
            $params = $notificationRequest->all();
            foreach ($params as $key => $value) {
                Log::info($key . ': ' . $value);
            }
            event(new StreamStarted($notificationRequest));
            Log::info(__CLASS__ . ': [END - Stream Start]');
        } catch (ValidationException $e) {
            if (strpos($e->getMessage(), 'trans') === false) {
                Log::error('Validation Failed: ' . $e->getResponse()->getContent());
            }
            $e->getResponse()->send();
        }
    }

    /**
     * Stream End Notification
     * API Method
     *
     *
     * @return bool
     */
    public function streamEnd(StreamEndNotificationRequest $notificationRequest)
    {
        try {
            Log::info(__CLASS__ . ': [START - Stream End]');

            // Validate Notification Request
            $live_video_storage_name = config('livestream.default_live_disk');
            $correctTopic = config('livestream.livestream-s3-new-video-topicArn');

            // Validation
            $notificationRequest->validateAll($correctTopic, Storage::disk($live_video_storage_name));

            // Broadcast StreamEnded Event to kickoff Processes
            event(new StreamEnded($notificationRequest));
            Log::info(__CLASS__ . ': [END - Stream End]');
        } catch (ValidationException $e) {
            if (strpos($e->getResponse()->getContent(), 'trans') === false) {
                Log::error('Validation Failed: ' . $e->getResponse()->getContent());
            }
            $e->getResponse()->send();
        }
    }

    /**
     * Get RSS Feed of Episodes
     *
     *
     * @return $this
     */
    public function rss(LivestreamAccount $LivestreamAccount)
    {
        $episodeService = new EpisodeService($LivestreamAccount);
        $feed = $episodeService->getRssFeed();

        return response($feed)->header('Content-type', 'application/xml');
    }

    /**
     * Import Episodes into Livestream Account
     *
     *
     * @return ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function import(EpisodeImportRequest $request)
    {
        $episodeService = new EpisodeImportService($request);
        $response = $episodeService->import();

        return response($response);
    }

    /**
     * Update the thumbnail on given Episode
     *
     * @param  Request  $request
     * @return mixed
     */
    public function storeThumbnail(LivestreamRequest $request, Episode $episode)
    {
        return Omnia::interact(UpdateEpisodeThumbnail::class, [$episode, $request->all()]);
    }

    /**
     * Delete the thumbnail file and remove from Episode
     *
     *
     * @return mixed
     */
    public function removeThumbnail(Episode $episode)
    {
        return Omnia::interact(DeleteEpisodeThumbnail::class, [$episode]);
    }

    /**
     * @return mixed
     */
    public function getVideosForEpisode(Episode $episode)
    {
        $videos = $episode->videos;

        foreach ($videos as $video) {
            $video->setAttribute('playback_url', $video->playback_url);
            $video->setAttribute('download_url', $video->download_url);
        }

        return $videos;
    }

    /**
     * @throws ApiException
     */
    public function getUploadUrl()
    {
        $uploadInfo = (new MuxService)->getUploadInfo();

        return [
            'url' => $uploadInfo['data']->getUrl(),
            'id' => $uploadInfo['id'],
        ];
    }

    /**
     * Save the episode with upload video.
     *
     * @param  EpisodeEditRequest  $request
     * @return JsonResponse
     */
    public function saveEpisode(Request $request)
    {
        $episode = (new CreateNewEpisodeFromUploadedVideo)->execute($request->upload_id);

        return response()->json([
            'success' => true,
            'data' => $episode,
        ]);
    }

    /**
     * @return mixed
     *
     * @throws ApiException
     */
    public function downloadSingle(Request $request)
    {
        // Check if the livestream account owns this asset or not
        /** @var Episode $episode */
        $episode = Episode::query()
            ->where('livestream_account_id', $this->livestreamAccountId)
            ->where('mux_asset_id', $request->mux_asset_id)
            ->first();

        if (! $episode) {
            abort(403, 'You do not have permission to download this episode');
        }

        $asset = $episode->asMuxAsset();

        // Do nothing if asset is not found or this asset does not supports mp4.
        if (! $asset || ! $asset->isDownloadable()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Cannot find asset for this episode or it does not support MP4.',
            ], 404);
        }

        if (! ($playbackId = $asset->defaultPlaybackId())) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Cannot find default playback id.',
            ], 404);
        }

        return response()->download($asset->downloadLink());
    }

    /**
     * @return JsonResponse
     */
    public function download()
    {
        // Check if the livestream account has a waiting download.
        $waitingDownload = EpisodeDownload::query()
            ->where('livestream_account_id', $this->_livestreamAccount->id)
            ->waitingDownload()
            ->first();

        // If yes, don't create another download.
        if ($waitingDownload) {
            return response()->json([
                'status' => $waitingDownload->status,
                'download_code' => $waitingDownload->code,
            ]);
        }

        // Create a download record in the database.
        $episodeDownload = EpisodeDownload::create([
            'code' => Str::random(22),
            'user_id' => auth()->id(),
            'livestream_account_id' => $this->_livestreamAccount->id,
            'expires_at' => now()->addDays(config('omnia.episode_download_link_lasts', 7)),
        ]);

        // Dispatch download episodes job.
        DownloadEpisodes::dispatch($episodeDownload, $this->_livestreamAccount->id);

        return response()->json([
            'status' => $episodeDownload->status,
            'download_code' => $episodeDownload->code,
        ]);
    }
}
