<?php

namespace Modules\Livestream\Listeners\Episode;

use Modules\Livestream\Events\Stream\StreamEnded;
use Modules\Livestream\Events\Stream\StreamStarted;

class UpdateEpisodeLiveStatus
{
    /**
     * Handle the event.
     *
     * @param  StreamEnded | StreamStarted  $event
     * @return bool
     */
    public function handle($event)
    {
        if ($event instanceof StreamStarted) {
            return true;
//            $episode->syncVideos();
        } elseif ($event instanceof StreamEnded) {
            return true;
        }
    }
}
