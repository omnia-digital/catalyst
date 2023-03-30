<?php

namespace Modules\Livestream\Listeners\EpisodeDownload;

use Modules\Livestream\Notifications\EpisodeDownloadWasCompletedNotification;
use Modules\Livestream\Events\EpisodeDownload\EpisodeDownloadIsReady;

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
