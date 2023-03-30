<?php

namespace Modules\Livestream\Listeners\Video;

use Illuminate\Support\Facades\Log;
use Modules\Livestream\Jobs\Videos\MoveLiveVideoFilesToTmp as MoveLiveVideoFilesToTmp_Job;

/**
 * Class MoveLiveVideoFilesToTmp
 */
class MoveLiveVideoFilesToTmp
{
    /**
     * This is STEP 1 in ProcessFinishedLiveVideos
     * Handle the event
     */
    public function handle($event)
    {
        Log::info(__CLASS__ . ' STARTED');
        $videoProcessorQueueName = config('livestream_queue.queue-names.videoProcessor-high');
        $job = (new MoveLiveVideoFilesToTmp_Job($event->episodeService))->onQueue($videoProcessorQueueName);
        dispatch($job);
        Log::info('MoveLiveVideoFilesToTmp Job added to queue "' . $videoProcessorQueueName);
        Log::info(__CLASS__ . ' ENDED');
    }
}
