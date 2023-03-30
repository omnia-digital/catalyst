<?php

namespace Modules\Livestream\Listeners\EpisodeDownload;

use Modules\Livestream\Events\EpisodeDownload\EpisodeDownloadIsReady;
use Modules\Livestream\Notifications\EpisodeDownloadWasCompletedNotification;

class NotifyWhenEpisodeDownloadReady
{
    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(EpisodeDownloadIsReady $event)
    {
        $event->episodeDownload->user->notify(new EpisodeDownloadWasCompletedNotification(
            $event->episodeDownload
        ));
    }
}
