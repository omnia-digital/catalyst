<?php

namespace Modules\Livestream\Listeners\Episode;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Modules\Livestream\Episode;
use Modules\Livestream\Events\Video\VideoAssetCreated;

class UpdateEpisodeDuration implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param  VideoAssetCreated  $event
     * @return void
     */
    public function handle($event)
    {
        $episode = Episode::where('mux_asset_id', $event->data['object']['id'])->first();

        if (! $episode) {
            Log::info('Cannot find the episode to update duration. Will update in the command job.');

            return;
        }

        // Convert duration from second to milliseconds.
        $duration = collect($event->data['data']['recording_times'])->sum('duration') * 1000;

        // Only update if duration is changed.
        if ($duration != $episode->duration) {
            $episode->update(['duration' => $duration]);
        }
    }
}
