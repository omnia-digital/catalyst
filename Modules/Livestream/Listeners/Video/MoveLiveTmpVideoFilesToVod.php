<?php

namespace App\Listeners\Video;

use Illuminate\Support\Facades\Log;
use App\Events\Stream\StreamEnded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\Video\FinishedMovingLiveTmpVideosToVod;
use App\Events\Video\LiveVideosFinishedProcessing;
use App\Jobs\Videos\MoveLiveTmpVideoFilesToVod as MoveLiveTmpVideoFilesToVod_Job;
use App\Jobs\Videos\MoveLiveTmpVideosToVod;

class MoveLiveTmpVideoFilesToVod
{

    /**
     * Handle the event.
     *
     * @param  $event
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
