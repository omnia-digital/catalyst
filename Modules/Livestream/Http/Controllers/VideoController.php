<?php

    namespace App\Http\Controllers;

    use App\Exceptions\MissingParameterException;
    use App\Http\Requests\Request;
    use App\Omnia;
    use App\SocialAccount;
    use Carbon\Carbon;
    use Illuminate\Auth\AuthenticationException;
    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Config;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\Storage;
    use App\Episode;
    use App\Http\Requests\LivestreamRequest;
    use App\LivestreamAccount;
    use App\Repositories\VideoRepository;
    use App\Services\SocialAccountService;
    use App\Services\StreamIntegrationService;
    use App\Services\StreamTargetService;
    use App\StreamIntegration;
    use App\Video;
    use App\VideoSourceType;
    use Livestream\Livestream;
    use mysql_xdevapi\Exception;

    class VideoController extends LivestreamController
    {
        /**
         * Get all videos for LivestreamAccount
         */
        public function index()
        {
            return $this->_livestreamAccount->videos;
        }

        /**
         * Get Video
         */
        public function show(Video $video)
        {
            return $video;
        }

        /**
         * Create a Video
         *
         * @param LivestreamRequest $request
         *
         * @return
         * @throws \Exception
         */
        public function store(LivestreamRequest $request)
        {
            $params = $request->all();
            if ($request->filled('schedule')) {
                $schedule = $request->get('schedule');
                if ($schedule) {
                    $video = $this->scheduleFacebookLiveVideo($request);
                }
            } else {
                $video = Video::create($params);
            }

            return $video;
        }


        /**
         * Schedule a new Facebook Live Video
         *
         * @param  $request
         *
         * @return \Illuminate\Http\JsonResponse
         * @throws \Exception
         */
        public function scheduleFacebookLiveVideo($request)
        {
            try {
                DB::beginTransaction();

                $timezone = Omnia::getTimezone($request->get('timezone'), $this->_livestreamAccount->team);

                // check for a livestreamAccount
                if (empty($this->_livestreamAccount)) {
                    // if we couldn't find a livestream account through the user, then check if it's in the payload
                    if ($request->filled('livestream_account_id')) {
                        $livestreamAccountId = $request->get('livestream_account_id');
                        $livestreamAccount   = Livestream::getLivestreamAccount($livestreamAccountId);
                        $team                = $livestreamAccount->team;
                        $users               = $team->users;
                        // Check if this user belongs to the team associated with this livestream account
                        $userBelongsToTeam = $users->contains(Auth::user());

                        if ( ! $userBelongsToTeam) {
                            throw new AuthenticationException("The authenticated user does not have access to this team's resources");
                        }
                    } else {
                        throw new LivestreamAccountIdNotFoundException();
                    }
                } else {
                    $livestreamAccount = $this->_livestreamAccount;
                }

                // Look for Episode
                if ($request->filled('episode_id')) {
                    $episode = Episode::find($request->get('episode_id'));
                }

                // We couldn't find the Episode
                if (empty($episode) || empty($episode->id)) {
                    // if we don't have one, create one using title and description given
                    if ($request->filled('planned_start_time')) {
                        $planned_start_time = $request->get('planned_start_time');

                        // If it's numeric, then we will assume it's a timestamp (UTC)
                        if ( ! is_numeric($planned_start_time)) {
                            $carbonTime         = new Carbon($planned_start_time, $timezone);
                            $planned_start_time = $carbonTime->setTimezone(config('app.timezone'))->timestamp;
                        }
                    } else {
                        $planned_start_time = now()->addMinutes(15)->timestamp;
                    }

                    if ( ! $request->filled('title')) {
                        throw new MissingParameterException(['episode_title', 'episode_id'], "Episode Title must be provided if you do not pass in an Episode Id");
                    } else {
                        $episodeData                          = [];
                        $episodeData['title']                 = $request->get('title');
                        $episodeData['livestream_account_id'] = $livestreamAccount->id;
                        $episodeData['planned_start_time']    = $planned_start_time;
                        if ($request->filled('description')) {
                            $episodeData['description'] = $request->get('description');
                        }
                        $episode = Episode::create($episodeData);

                        // Setup Video Data from Episode
                        $videoData = [
                            'title'       => $episode->title,
                            'description' => $episode->description,
                            'episode_id'  => $episode->id,
                        ];
                    }
                } else {
                    // get $planned_start_time from Episode
                    if ( ! empty($episode->planned_start_time)) {
                        $planned_start_time = $episode->planned_start_time->timestamp;
                    } else if ($request->filled('planned_start_time')) {
                        $planned_start_time = $request->get('planned_start_time');

                        // If it's numeric, then we will assume it's a timestamp
                        if ( ! is_numeric($planned_start_time)) {
                            $carbonTime         = new Carbon($planned_start_time, $timezone);
                            $planned_start_time = $carbonTime->setTimezone(config('app.timezone'))->timestamp;
                        }

                        $episode->planned_start_time = $planned_start_time;
                        $episode->save();
                    } else {
                        throw new \Exception('Could not find planned_start_time on Episode or in Request');
                    }

                    // Setup Video Data from Episode and passed in data
                    $videoData = [
                        'episode_id' => $episode->id
                    ];
                    if ($request->filled('title')) {
                        $videoData['title'] = $request->get('title');
                    }
                    if ($request->filled('description')) {
                        $videoData['description'] = $request->get('description');
                    }
                }

                // Get Facebook Video Source Type
                $videoSourceType = VideoSourceType::where('slug', '=', 'facebook')->first();
                if ( ! empty($videoSourceType)) {
                    $videoData['video_source_type_id'] = $videoSourceType->id;
                } else {
                    throw new \Exception('Could not find Facebook Video Source Type');
                }

                // If Facebook pages are passed in request, then we need to create & schedule a video for each page
                if ( ! $request->filled('facebook_pages')) {
                    throw new Exception('Could not find Facebook Pages to schedule videos on in Request');
                } else {
                    $request_facebook_pages = $request->get('facebook_pages');
                    $user                   = Auth::user();
                    $socialAccounts         = SocialAccount::whereUserId($user->id)->where('provider', '=', 'facebook')->get();
                    //@note this will not work once we have more than one social account per user
                    // for now, we will simply grab the first one
                    $facebookSocialAccount = $socialAccounts->first();

                    // Grab all facebook pages that the user has admin access to
                    $socialAccountService    = new SocialAccountService($facebookSocialAccount);
                    $all_user_facebook_pages = collect($socialAccountService->getFacebookPages());

                    $videos = collect();
                    foreach ($request_facebook_pages as $fb_page) {
                        // find if fb_page is in user facebook pages
                        $found_fb_page = $all_user_facebook_pages->first(function ($item, $key) use ($fb_page) {
                            return $item['id'] == $fb_page['id'];
                        });

                        if ( ! empty($found_fb_page)) {
                            $teamObject = [
                                'id'           => $found_fb_page['id'],
                                'access_token' => $found_fb_page['access_token']
                            ];

                            // create the Omnia Video
                            $video = Video::create($videoData);

                            // Create the Facebook Live Video
                            $params = [
                                'title'       => $video->title,
                                'description' => $video->description,
                                //                                'planned_start_time' => $planned_start_time, // removed this because it automatically makes a "this page plans to go live" post
                                //                                'status'             => 'SCHEDULED_UNPUBLISHED' // @TODO [Josh] - this is default for now, we might take it as a parameter in the future
                            ];

                            $streamTargetService = new StreamIntegrationService($livestreamAccount);
                            $fbVideo             = $streamTargetService->createFacebookLiveVideo($params, $teamObject);

                            // attach facebook video info to omnia video object
                            $video->stream_url              = $fbVideo['secure_stream_url'];
                            $video->video_source_account_id = $teamObject['id']; // account id
                            $video->video_source_id         = $fbVideo['id']; // video id
                            $video->save();

                            $videos->push($video);
                        }
                    }
                }

                DB::commit();

                $episode->load('videos');

                return response()->json([
                    'success' => true,
                    'episode' => $episode
                ]);

            } catch (\Exception $e) {
                DB::rollback();
                Log::error($e->getMessage());
                throw $e;
            }
        }

        /**
         * Return the most Recent Video for this LivestreamAccount
         *
         * @param null $livestreamAccountId
         *
         * @return mixed
         */
        public function mostRecentVideo($livestreamAccountId = null)
        {
            $result = false;

            if (empty($livestreamAccountId) && ! empty($this->_livestreamAccount)) {
                $video = $this->_livestreamAccount->mostRecentVideo();
            } else {
                $video = LivestreamAccount::findOrFail($livestreamAccountId)->mostRecentVideo();
            }

            if ( ! empty($video)) {
                $result = $video;
            }

            return response()->json($result);
        }

        /**
         * Download a video from file storage
         *
         * @param Video $video
         *
         * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
         */
        public function downloadVideo(Video $video)
        {
//            if ( ! empty($video->episode->mux_asset_id)) {
//                $mux_asset_id = $video->episode->mux_asset_id;
//                // get download url
//            }

//            $s3               = Storage::disk('s3-vod');
//            $bucket           = Config::get('filesystems.disks.s3-vod.bucket');
//            $fileDownloadName = $video->episode->livestreamAccount->account_slug . '_' . $video->episode->id . '_' . $video->id . '_' . Carbon::now()->timestamp . '.' . $video->file_type;
//            $client           = $s3->getDriver()->getAdapter()->getClient();
//            $expiry           = "+240 minutes";
//            $command          = $client->getCommand('GetObject', [
//                'Bucket'                     => $bucket,
//                'Key'                        => $video->full_file_path,
//                'ResponseContentDisposition' => 'attachment; filename="' . $fileDownloadName . '"',
//            ]);
//
//            $request = $client->createPresignedRequest($command, $expiry);

            return redirect($video->download_url .'?download=' . str_slug($video->episode->title));
        }

        /**
         * Update a Video
         *
         * @param Request $request
         * @param Video   $video
         *
         * @return Video
         * @throws \Facebook\Exceptions\FacebookResponseException
         * @throws \Facebook\Exceptions\FacebookSDKException
         */
        public function update(Request $request, Video $video)
        {
            $params = $request->all();

            DB::beginTransaction();

            $video->update($params);
            if ( ! empty($video->video_source_id)) {
                $facebookResponse = $this->updateFacebookLiveVideo($video);
            }

            DB::commit();

            return $video;
        }

        /**
         * Update a Facebook Live Video
         *
         * @param $video
         *
         * @return null|array $fbVideoResponse array of data from facebook or nul if we couldn't find the team page id
         * @throws \Facebook\Exceptions\FacebookResponseException
         * @throws \Facebook\Exceptions\FacebookSDKException
         */
        public function updateFacebookLiveVideo($video)
        {
            $params = [
                'video_id'    => $video->video_source_id,
                'title'       => $video->title,
                'description' => $video->description,
            ];

            $user                  = Auth::user();
            $socialAccounts        = SocialAccount::whereUserId($user->id)->where('provider', '=', 'facebook')->get();
            $facebookSocialAccount = $socialAccounts->first();

            // Grab all facebook pages that the user has admin access to
            $socialAccountService    = new SocialAccountService($facebookSocialAccount);
            $all_user_facebook_pages = collect($socialAccountService->getFacebookPages());

            $fb_page = $video->video_source_account_id;
            // find if fb_page is in user facebook pages
            if ( ! empty($fb_page)) {
                $found_fb_page = $all_user_facebook_pages->first(function ($item, $key) use ($fb_page) {
                    return $item['id'] == $fb_page;
                });

                if ( ! empty($found_fb_page)) {
                    $teamObject = [
                        'id'           => $found_fb_page['id'],
                        'access_token' => $found_fb_page['access_token']
                    ];

                    $streamTargetService = new StreamIntegrationService($this->_livestreamAccount);
                    $fbVideoResponse     = $streamTargetService->updateFacebookLiveVideo($params, $teamObject);

                    return $fbVideoResponse;
                }
            }
        }

        /**
         * Delete one or more Videos
         *
         * @param $ids
         *
         * @return int
         */
        public function destroy($ids)
        {
            $result = Omnia::interact(VideoRepository::class . '@destroy', [$ids]);

            return response()->json($result);
        }
    }
