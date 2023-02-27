<?php

namespace App\Listeners\EpisodeDownload;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;
use App\Events\EpisodeDownload\EpisodeDownloadIsReady;

class DeleteEpisodeFiles implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param EpisodeDownloadIsReady $event
     * @return void
     */
    public function handle(EpisodeDownloadIsReady $event)
    {
        $folderPath = Storage::disk('episode-download')->getAdapter()->getPathPrefix() . '/' . $event->episodeDownload->code;

        array_map('unlink', glob("{$folderPath}/*.mp4"));
    }
}
