<?php

namespace App\Listeners\EpisodeDownload;

use App\Notifications\EpisodeDownloadWasCompletedNotification;
use App\Events\EpisodeDownload\EpisodeDownloadIsReady;

class NotifyWhenEpisodeDownloadReady
{
    /**
     * Handle the event.
     *
     * @param EpisodeDownloadIsReady $event
     * @return void
     */
    public function handle(EpisodeDownloadIsReady $event)
    {
        $event->episodeDownload->user->notify(new EpisodeDownloadWasCompletedNotification(
            $event->episodeDownload
        ));
    }
}
