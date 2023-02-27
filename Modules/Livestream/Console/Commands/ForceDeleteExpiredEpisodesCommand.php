<?php namespace Modules\Livestream\Console\Commands;

use Modules\Livestream\Models\Episode;
use Illuminate\Console\Command;

class ForceDeleteExpiredEpisodesCommand extends Command
{
    protected $signature = 'episodes:force-delete';

    protected $description = 'Force delete expired episodes.';

    public function handle()
    {
        Episode::with('video', 'media', 'livestreamAccount')
            ->shouldBeForceDeleted()
            ->get()
            ->each(fn(Episode $episode) => $episode->purge());
    }
}
