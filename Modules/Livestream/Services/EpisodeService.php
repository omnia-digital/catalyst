<?php

namespace Modules\Livestream\Services;

use Modules\Livestream\Omnia;
use Modules\Livestream\Services\ImageService;
use Carbon\Carbon;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Modules\Livestream\Contracts\Services\Adapters\HostingProviderAdapter;
use Modules\Livestream\Events\Episode\ImportRssEpisodeAddedToQueue;
use Modules\Livestream\Events\Episode\ImportRssEpisodeFinished;
use Modules\Livestream\Events\Episode\ImportRssEpisodeStarted;
use Modules\Livestream\Exceptions\FailedToProcessVideoException;
use Modules\Livestream\Exceptions\VideoProcessingNotNeededException;
use Modules\Livestream\Http\Requests\EpisodeImportRequest;
use Modules\Livestream\Http\Requests\SermonBrowserWPPluginImportRssRequest;
use Modules\Livestream\Jobs\Videos\importRemoteMP4FilesToVodAndCreateEpisodes;
use Modules\Livestream\Jobs\Videos\MoveUrlFileToVod;
use Modules\Livestream\Repositories\VideoRepository;
use Modules\Livestream\Services\Adapters\HostingProviderRssImportAdapter;
use Modules\Livestream\Services\LivestreamService;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Modules\Livestream\Episode;
use Modules\Livestream\Events\Video\FinishedMovingLiveTmpVideosToVod;
use Modules\Livestream\Jobs\Videos\MoveLiveTmpTransVideoFilesToVod;
use Modules\Livestream\Jobs\Videos\MoveLiveVideoFilesToTmp;
use Modules\Livestream\LivestreamAccount;
use Modules\Livestream\Video;
use Livestream\Livestream;
use Suin\RSSWriter\Channel;
use Suin\RSSWriter\Feed;
use Suin\RSSWriter\Item;
use willvincent\Feeds\Facades\FeedsFacade;

class EpisodeService extends LivestreamService
{
// @TODO [Josh] - need to completely refactor this class because it will be heavily used and needs to be as efficient and clear as possible. right now its very confusing and has a lot of anti-patterns, but I need to get things done quickly so I don't have time to refactor it right now
    /**
     * LivestreamAccount
     * @var LivestreamAccount
     */
    private $_livestreamAccount;

    /*
     * Storage for Live Videos
     */
    private $_liveStorage;

    /*
     * Storage for VOD Videos
     */
    private $_vodStorage;

    /*
     * Name of Live Storage (allows serialization)
     */
    private $_liveStorageName;

    /*
     * Name of VOD Storage (allows serialization)
     */
    private $_vodStorageName;

    public $video;

    public $episode;

    public $successFullyMovedToVodTmpFiles = [];

    /**
     * EpisodeService constructor.
     * @param LivestreamAccount|int|null
     * @param $liveStorageName
     * @param $vodStorageName
     */
    public function __construct($livestreamAccount = null, $liveStorageName = null, $vodStorageName = null)
    {
        $this->_livestreamAccount = Livestream::getLivestreamAccount($livestreamAccount);
        if (!empty($liveStorageName)) {
            $this->_liveStorageName = $liveStorageName;
        }
        if (!empty($vodStorageName)) {
            $this->_vodStorageName = $vodStorageName;
        }
    }

    /**
     * Serialization
     */
    public function __sleep()
    {
        $serializeVars = [
            '_liveStorageName',
            '_vodStorageName',
            '_livestreamAccount',
            'video',
            'episode',
            'successFullyMovedToVodTmpFiles'
        ];
        return $serializeVars;
    }

    /**
     * De-serialization
     */
    public function __wakeup()
    {
        if (!empty($this->_liveStorageName)) {
            $this->_liveStorage = Storage::disk($this->_liveStorageName);
        }
        if (!empty($this->_vodStorageName)) {
            $this->_vodStorage = Storage::disk($this->_vodStorageName);
        }
        return $this;
    }

    public function getEpisodeForStream($realStreamName)
    {
        $episodeAutoStreamName = config('livestream.livestream_episode_auto_record_stream_name');
        // Check StreamName
        // If Numeric, assume its an id for an existing Episode
        if (is_numeric($realStreamName)) {
            // then find the episode by the id and set to "currently streaming",
            $episode = Episode::find($realStreamName);
            if (!empty($episode)) {
                Log::info('Episode found with id: ' . $episode->id);
            } else {
                // If episode is not found by this id, we will create a new one with the title as the streamName
                Log::info('Episode not found with id: ' . $realStreamName . ". Going to create a new episode with title as streamName: " . $realStreamName);
                $episodeData = json_decode($this->_livestreamAccount->default_episode_template->template);
                $episodeData['title'] = $realStreamName;
            }

            // If it is equal to the auto stream name, attempt to create the episode using an Auto Schedule
        } else {
            if ($realStreamName === $episodeAutoStreamName) {

                // Find Schedules for this LivestreamAccount
                $schedules = $this->_livestreamAccount->schedules;
                $current_date = new Carbon();
                $possibleSchedules = collect();

                // Check each schedule to see which ones fit the current Date and Time
                if (!$schedules->isEmpty()) {
                    foreach ($schedules as $schedule) {
                        if ($schedule->isWithinScheduleTime($current_date)) {
                            $possibleSchedules->push($schedule);
                        }
                    }
                }
                // If there were any matched Schedules
                if (!$possibleSchedules->isEmpty()) {
                    // create from Schedule Template Data
                    // @TODO [Josh] - for now I am just going to grab the first possible schedule
                    $scheduleForEpisode = $possibleSchedules->first();

                    $episodeData = $scheduleForEpisode->episodeTemplate->createEpisodeFromTemplate();
                } else {
                    // No matched Schedules, create an Episode with Default Data
                    // check if account has default episode data
                    // if they do, use it
                    // if not, use app default data
                    // Get Default Episode Data from this LivestreamAccount ( it is stored as a JSON field in the database)
                    $episodeData = json_decode($this->_livestreamAccount->default_episode_template->template, true);
                }
            } else {
                if (is_string($realStreamName)) {
                    // Assuming Episode name must be a string, so we want to use that as the episode name
                    $episodeData = json_decode($this->_livestreamAccount->default_episode_template->template, true);
                    $episodeData['title'] = $realStreamName;
                } else {
                    throw new Exception('Unable to Determine the type of Episode based on the streamName. It must either be auto (Auto Episode Creation), an integer (Id of the episode), or a string (Title for new Episode)');
                }
            }
        }

        // Create an Episode if it doesn't already exist
        if (empty($episode)) {
            $episode = Episode::create($episodeData);
            Log::info('New Episode created with id: ' . $episode->id);
        }

        return $episode;

    }

    /**
     * Move Video Files on S3 Live Bucket from initial directory to the tmp directory in order to await processing
     *
     */
    public function moveLiveVideoFilesToTmp()
    {
        Log::info('[START - ' . __FUNCTION__ . ' ]');

        if (empty($this->video->s3LivestreamAccountPath)
            || empty($this->video->fullFilePath)
            || empty($this->video->fileName)
            || empty($this->video->tempFullFilePath)
            || empty($this->video->tempVideoDirPath)
        ) {
            throw new Exception('Invalid parameters for ' . __FUNCTION__);
        }

        if (empty($this->_liveStorage)) {
            if (!empty($this->_liveStorageName)) {
                $this->_liveStorage = Storage::disk($this->_liveStorageName);
            }

            if (empty($this->_liveStorage)) {
                throw new Exception(__FUNCTION__ . ': LiveStorage not set. Unable to move files without a valid storage.');
            }
        }
        // Move this file from current location to temporary path (this will also create the directory, since it doesn't exist)
        $this->_liveStorage->move($this->video->fullFilePath, $this->video->tempFullFilePath);

        // Check other files in the same directory and move if Trans Files
        $this->moveLiveTransVideosToTmp();

        Log::info('[END - ' . __FUNCTION__ . ' ]');
    }

    /**
     * Move Live Trans Videos to Tmp directory so it doesn't get overwritten
     */
    public function moveLiveTransVideosToTmp()
    {
        $this->video->transTempFilesArray = [];
        // if its an associated _trans_ file, then move it to the temp directory as well
        $otherFilesArray = $this->_liveStorage->files($this->video->s3LivestreamAccountPath);
        foreach ($otherFilesArray as $otherfilePath) {
            $otherFile = substr($otherfilePath, strpos($otherfilePath, $this->video->fileName . '_trans_'));
            if ($otherFile !== false) {
                $otherTempFullFilePath = $this->video->tempVideoDirPath . $otherFile;
                $this->_liveStorage->move($otherfilePath, $otherTempFullFilePath);
                $this->video->transTempFilesArray[] = $otherFile;
            }
        }
    }

    /**
     * Move Video Files in Tmp Directory on S3 Live Bucket
     * to LivestreamAccount/Episode directory on S3 Vod Bucket
     *
     */
    public function moveTmpVideoFilesToVod()
    {
        try {
            Log::info('[START - ' . __FUNCTION__ . ' ]');

            $this->successFullyMovedToVodTmpFiles = [];

            if (empty($this->_vodStorage) || empty($this->_liveStorage)) {
                if (empty($this->_vodStorage) && !empty($this->_vodStorageName)) {
                    $this->_vodStorage = Storage::disk($this->_vodStorageName);
                }
                if (empty($this->_liveStorage) && !empty($this->_liveStorageName)) {
                    $this->_liveStorage = Storage::disk($this->_liveStorageName);
                }
                if (empty($this->_vodStorage) || empty($this->_liveStorage)) {
                    throw new Exception('VodStorage not set. Unable to move files without a valid storage.');
                }
            }
            // Move All Files in Temp Directory for this Episode from Live S3 Bucket to the VOD S3 Bucket
            $this->video->newFileName = trim($this->video->uniqueName, '_');
            $this->video->episodePath = $this->video->s3LivestreamAccountPath . $this->episode->id . '/';
            $newFilePath = $this->video->episodePath . $this->video->newFileName . $this->video->fileExt;

            $tmpFileToVodMsg = 'Live Tmp file:' . $this->video->tempFullFilePath . ' to Vod: ' . $newFilePath;
            Log::info('Attempting to move: ' . $tmpFileToVodMsg);

            // Copy Stream File to VOD
            $srcFileStream = $this->_liveStorage->readStream($this->video->tempFullFilePath);
            Log::info('Finished reading file stream from live.');
            Log::info('Attempting to write file stream to vod...');
            if ($srcFileStream === false) {
                Log::error('Failed to read the video file from Live so we cannot move it');
                $success = false;
            } else {
                $success = $this->_vodStorage->writeStream($newFilePath, $srcFileStream);
                Log::info('Finished trying to write file stream to vod...');
            }

            if ($success != false) {
                Log::info('Successfully moved: ' . $tmpFileToVodMsg);
                $this->successFullyMovedToVodTmpFiles[] = $this->video->tempFullFilePath;
            } else {
                throw new \Exception('Failed to move: ' . $tmpFileToVodMsg);
            }

            // Move Trans files
            // @TODO [Josh] - I need to have this as a progress bar in the episode detail screen so the user can see the progress of their videos
            if (!empty($this->video->transTempFilesArray)) {
                $videoProcessorQueueName = config('livestream_queue.queue-names.videoProcessor-low');
                $job = (new MoveLiveTmpTransVideoFilesToVod($this))->onQueue($videoProcessorQueueName);
                dispatch($job);
                Log::info('MoveLiveTmpTransVideoFilesToVod Job added to queue "' . $videoProcessorQueueName);
            } else {
                event(new FinishedMovingLiveTmpVideosToVod($this));
            }
            Log::info('[END - ' . __FUNCTION__ . ' ]');

            return $this->successFullyMovedToVodFiles;

        } catch (\Exception $e) {
            throw new \Exception(__FUNCTION__ . " : " . $e->getMessage(),$e->getCode(),$e);
        }
    }

    /**
     * Move Live Trans Videos to Vod
     */
    public function moveLiveTransVideosToVod()
    {
        try {
            foreach ($this->video->transTempFilesArray as $transTempFile) {
                $transTempFullFilePath = $this->video->tempVideoDirPath . $transTempFile;

                // @TODO [Josh] - I can use this as a Subscription plan limiter to remove HD files if they are not on a paid plan
                $resolutionName = rtrim(trim(substr(substr($transTempFile, 0, strpos($transTempFile, '.')),
                    strrpos($transTempFile, '_')), '_'), 'p');
                if ($resolutionName === 'source') {
                    $this->successFullyMovedToVodTmpFiles[] = $transTempFullFilePath; // even though we didn't actually move the source file, we need to delete this file
                    continue; // skips the rest for source file because its unnecessary
                }

                $newTransFile = $this->video->newFileName . substr($transTempFile, strpos($transTempFile, '_trans_'));
                $newTransFilePath = $this->video->episodePath . $newTransFile;

                $transFileToVodMsg = 'Live Trans file:' . $transTempFullFilePath . ' to Vod: ' . $newTransFilePath;
                Log::info('Attempting to move: ' . $transFileToVodMsg);

                // Copy Stream to Vod
                $transFileContents = $this->_liveStorage->readStream($transTempFullFilePath);
                $success = $this->_vodStorage->writeStream($newTransFilePath, $transFileContents);

                if ($success != false) {
                    Log::info('Successfully moved: ' . $transFileToVodMsg);
                    $this->successFullyMovedToVodTmpFiles[] = $transTempFullFilePath;
                } else {
                    throw new \Exception('Failed to move: ' . $transFileToVodMsg);
                }
            }

            event(new FinishedMovingLiveTmpVideosToVod($this));

        } catch (\Exception $e) {
            throw new \Exception(__FUNCTION__ . " : " . $e->getMessage());
        }
    }

    /**
     * Go back and delete any Tmp files that were successfully moved to Vod
     */
    public function cleanUpTmpVideoFiles()
    {
        if (!empty($this->successFullyMovedToVodTmpFiles)) {
            foreach ($this->successFullyMovedToVodTmpFiles as $tmpFilePath) {
                $this->_liveStorage->delete($tmpFilePath);
            }
        }
    }

    /*
     * Remove the Episode and move associated video files from storage.
     */
    public function deleteEpisode($episode, $deleteVideos)
    {
        if (is_int($episode)) {
            $episode = Episode::findOrFail($episode);
        }
        $videos = $episode->videos()->get();
        foreach ( $videos as $video ) {
            try {
                if ( $deleteVideos === true ) {
                    $result = Omnia::interact( VideoRepository::class . '@destroy', [ $video->id ] );
                } else {
                    $result = Omnia::interact( VideoRepository::class . '@removeFromEpisode', [ $video ] );
                }
            } catch(\Exception $e) {
                $errorMsg = 'Couldn\'t Delete Video: ' . $e->getMessage();
            }
            if ($result === false || !empty($errorMsg)) {
                $message = 'Failed to Delete Videos, cannot delete Episode';
                if (!empty($errorMsg)) {
                    $message .= ': ' . $errorMsg;
                }
                Log::error($message);
            }
        }

        // Delete on Mux if active
        if (!empty($episode->mux_asset_id)) {
            $muxService = new MuxService();
            $success = $muxService->deleteAsset($episode->mux_asset_id);
        }

        return Episode::destroy( $episode->id );
    }

    /**
     * Get the Cached Episode Rss Feed or Create a new one and return it
     *
     * @return mixed
     * @throws Exception
     */
    public function getRssFeed()
    {
        if (empty($this->_livestreamAccount)) {
            throw new Exception('Missing Livestream Account');
        }
        $rssFeedId = 'rss-feed-' . $this->_livestreamAccount->id;

        if (Cache::has($rssFeedId)) {
            $feed = Cache::get($rssFeedId);
        } else {
            $feed = $this->createRssFeed();
            Cache::add($rssFeedId, $feed, 5);
        }
        return $feed;
    }

    /**
     * Create Rss Feed of Episodes
     *
     * @param null $livestreamAccount
     * @return mixed|string|Feed
     */
    public function createRssFeed($livestreamAccount = null)
    {
        if (empty($livestreamAccount)) {
            $livestreamAccount = $this->_livestreamAccount;
        }
        $now = Carbon::now();
        $feed = new Feed();
        $channel = new Channel();
        $url = config('app.full_url');
        $channel
            ->title($livestreamAccount->team->name . ' Episodes')
            ->description('Episodes from ' . $livestreamAccount->team->name)
            ->url($url)
            ->language('en')
            ->copyright('Copyright (c) Omnia Church Apps - ' . $livestreamAccount->team->name)
            ->lastBuildDate($now->timestamp)
            ->appendTo($feed);

        $episodes = $livestreamAccount->episodes->sortByDesc('date_recorded');

        $activePlanId = $livestreamAccount->team->currentActivePlan()->id;
        if ($activePlanId === 'livestream-free') {
            $episodes = $episodes->take(1);
        }

        foreach ($episodes as $episode) {
            foreach ($episode->videos as $video) {
                $item = new Item();
                $url = config('livestream.aws_default_vod_bucket_url') . $video->full_file_path;
                $item
                    ->title($episode->title)
                    ->description($episode->description)
                    ->url($url)
                    ->pubDate($episode->date_recorded->timestamp)
                    ->guid($url, true)
                    ->enclosure($url, 1413883867,
                        'video/' . $video->file_type)// this length needs to be grabbed using ffmpeg dynamically so its the REAL length
                    ->appendTo($channel);
            }
        }

        $feed = (string)$feed;
        // Replace a couple items to make the feed more compliant
        $feed = str_replace(
            '<?xml version="1.0" encoding="UTF-8"?>',
            '',
            $feed
        );
        $feed = str_replace(
            '<rss version="2.0">',
            '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">',
            $feed
        );
        $feed = str_replace(
            '<channel>',
            '<channel>' . "\n" . '    <atom:link href="' . url('/livestream/episode/rss') .
            '" rel="self" type="application/rss+xml" />',
            $feed
        );
        return $feed;
    }

    /**
     * Remove a thumbnail from an Episode
     * @param $episode
     * @param bool $deleteImage
     */
    public function removeThumbnail($episode, $deleteImage = false)
    {
        $thumbnailId = $episode->thumbnail_image_id;
        $episode->thumbnail()->dissociate();
        $episode->save();

        if ($deleteImage === true) {
            $imageService = new ImageService();
            $imageService->deleteImage($thumbnailId);
        }
    }

    /**
     * Move Video Files from URL to Omnia Vod and create corresponding Episode
     *
     * @param $videoUrls
     * @throws Exception
     */
    public function importRemoteMP4FilesToVodAndCreateEpisodes(Collection $videoUrls)
    {
        event(new importRSSEpisodeStarted( $this->episode ));
        try {
            DB::beginTransaction();
            $this->episode->save();
            $amountOfUrls = count($videoUrls);
            $amountOfErrors = 0;
            foreach ($videoUrls as $videoURL) {
                try {
                    if (strpos($videoURL, '.mp4') === false) {
                        throw new VideoProcessingNotNeededException('Not an mp4 file, so it will not be imported');
                    } else {
                        $video = new Video();
                        $streamFile = fopen($videoURL, 'r');
                        $file_name = $this->episode->livestream_account_id . time() . uniqid();
                        $video_type = 'mp4';
                        $full_file_path = $this->episode->livestream_account_id . '/' . $this->episode->id . '/' . $file_name . '.' . $video_type;
                        $success = $this->_vodStorage->writeStream($full_file_path, $streamFile);
                        if ($success === true) {
                            $video->full_file_path = $full_file_path;
                            $video->title = $this->episode->title;
                            $video->file_type = $video_type;
                            $video->storage_source = 's3';
                            $video->file_name = $file_name;
                            $video->episode_id = $this->episode->id;
                            $video->save();
                        } else {
                            throw new FailedToProcessVideoException('Failed to copy video over to Omnia S3');
                        }
                    }
                } catch (\Exception $e) {
                    $amountOfErrors += 1;
                    Log::error($e->getMessage() . ": " . $videoURL);
                }
            }
            // If all videos fail, rollback Episode and Video creation
            if ($amountOfErrors === $amountOfUrls) {
                throw new Exception('All videos failed to import, not creating Episode.');
            } else {
                $this->episode->save();
                DB::commit();
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error(__FUNCTION__ . ': ' . $e->getMessage());
        }
        event(new importRSSEpisodeFinished( $this->episode ));
    }

}
