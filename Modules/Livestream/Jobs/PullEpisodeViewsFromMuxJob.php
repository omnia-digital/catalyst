<?php

namespace App\Jobs;

use App\Models\Episode;
use App\Models\VideoView;
use App\Services\Mux\MuxVideoView;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

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
