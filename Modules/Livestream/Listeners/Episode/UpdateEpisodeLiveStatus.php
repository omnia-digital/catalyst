<?php

namespace App\Listeners\Episode;

use App\Events\Stream\StreamStarted;
use App\Events\Stream\StreamEnded;

class UpdateEpisodeLiveStatus
{
    /**
     * Handle the event.
     *
     * @param  StreamEnded | StreamStarted $event
     * @return bool
     */
    public function handle($event)
    {
        if ($event instanceof StreamStarted) {
            return true;
//            $episode->syncVideos();
        } else if ($event instanceof StreamEnded) {
            return true;
        }

    }
}
