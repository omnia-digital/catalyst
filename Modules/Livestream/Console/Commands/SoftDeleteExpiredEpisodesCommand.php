<?php

namespace Modules\Livestream\Console\Commands;

use Illuminate\Console\Command;
use Modules\Livestream\Models\Episode;

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
