<?php namespace App\Console\Commands;

use App\Models\Episode;
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
