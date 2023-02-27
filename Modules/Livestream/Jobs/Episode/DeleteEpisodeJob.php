<?php namespace Modules\Livestream\Jobs\Episode;

use Modules\Livestream\Models\Episode;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class DeleteEpisodeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private Episode $episode) {}

    public function handle()
    {
        $this->episode->purge();
    }
}
