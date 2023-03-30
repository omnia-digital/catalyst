<?php

namespace Modules\Livestream\Jobs\Episode;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Livestream\Models\Episode;

class DeleteEpisodeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private Episode $episode)
    {
    }

    public function handle()
    {
        $this->episode->purge();
    }
}
