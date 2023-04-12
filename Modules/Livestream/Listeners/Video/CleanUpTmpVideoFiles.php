<?php

namespace Modules\Livestream\Listeners\Video;

use Illuminate\Support\Facades\Log;
use Modules\Livestream\Jobs\Videos\CleanUpTmpVideoFiles as CleanUpTmpVideoFiles_Job;

class CleanUpTmpVideoFiles
{
    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle($event)
    {
        Log::info(__CLASS__ . ' STARTED');
        $videoProcessorQueueName = config('livestream_queue.queue-names.videoProcessor-low');
        $job = (new CleanUpTmpVideoFiles_Job($event->episodeService))->onQueue($videoProcessorQueueName);
        dispatch($job);
        Log::info('CleanUpTmpVideoFiles Job added to queue "' . $videoProcessorQueueName);
        Log::info(__CLASS__ . ' ENDED');
    }
}
