<?php namespace App\Console\Commands;

use App\Models\Episode;
use Illuminate\Console\Command;

class SoftDeleteExpiredEpisodesCommand extends Command
{
    protected $signature = 'episodes:soft-delete';

    protected $description = 'Soft delete expired episodes.';

    public function handle()
    {
        Episode::query()
            ->expired()
            ->doNotStore()
            ->get()
            ->each(function (Episode $episode) {
                $episode->delete();
            });
    }
}
