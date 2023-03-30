<?php

namespace Modules\Livestream\Listeners\Episode;

use Modules\Livestream\Events\Stream\StreamStarted;
use Modules\Livestream\Events\Stream\StreamEnded;

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
