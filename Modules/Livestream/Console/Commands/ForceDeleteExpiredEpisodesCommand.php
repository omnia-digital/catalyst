<?php

namespace Modules\Livestream\Console\Commands;

use Illuminate\Console\Command;
use Modules\Livestream\Models\Episode;

class ForceDeleteExpiredEpisodesCommand extends Command
{
    protected $signature = 'episodes:force-delete';

    protected $description = 'Force delete expired episodes.';

    public function handle()
    {
        Episode::with('video', 'media', 'livestreamAccount')
            ->shouldBeForceDeleted()
            ->get()
            ->each(fn (Episode $episode) => $episode->purge());
    }
}
