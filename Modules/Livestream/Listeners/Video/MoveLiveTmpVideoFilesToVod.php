<?php

namespace Modules\Livestream\Listeners\Video;

use Illuminate\Support\Facades\Log;
use Modules\Livestream\Jobs\Videos\MoveLiveTmpVideoFilesToVod as MoveLiveTmpVideoFilesToVod_Job;

class MoveLiveTmpVideoFilesToVod
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
        $job = (new MoveLiveTmpVideoFilesToVod_Job($event->episodeService))->onQueue($videoProcessorQueueName);
        dispatch($job);
        Log::info('MoveLiveTmpVideoFilesToVod Job added to queue "' . $videoProcessorQueueName);
        Log::info(__CLASS__ . ' ENDED');
    }
}