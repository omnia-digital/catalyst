<?php

namespace Modules\Livestream\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Livestream\Models\Episode;
use Modules\Livestream\Models\VideoView;
use Modules\Livestream\Services\Mux\MuxVideoView;

class PullEpisodeViewsFromMuxJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private Episode $episode)
    {
    }

    public function handle()
    {
        // Make sure do not overwhelm Mux API.
        sleep(config('omnia.delay_pull_views_job_in_seconds'));

        app(MuxVideoView::class)
            ->getViews(episodeOrMuxAssetId: $this->episode)
            ->each(function (VideoView $videoView) {
                $this->episode->video->videoViews()->firstOrCreate(
                    ['viewer_id' => $videoView->viewer_id],
                    $videoView->toArray()
                );
            });
    }
}
