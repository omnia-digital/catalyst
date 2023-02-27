<?php

namespace App\Listeners\Episode;

use Illuminate\Support\Facades\Log;
use App\Jobs\Episode\SyncEpisodeVideos as SyncEpisodeVideos_Job;

class SyncEpisodeVideos
{
    /**
     * Handle the event.
     * @param $event
     */
    public function handle($event)
    {
        Log::info(__CLASS__ . ' STARTED');
        $videoProcessorQueueName = config('livestream_queue.queue-names.videoProcessor-high');
	    $episode = $event->episodeService->episode;
        $job = (new SyncEpisodeVideos_Job($episode))->onQueue($videoProcessorQueueName);
        dispatch($job);
        Log::info('SyncEpisodeVideos Job added to queue "' . $videoProcessorQueueName . " for Episode: " . $episode->id);
        Log::info(__CLASS__ . ' ENDED');
    }
}
