<?php

namespace Modules\Livestream\Console\Commands;

use Modules\Livestream\Models\Episode;
use Illuminate\Console\Command;

class RemoveLiveForEpisodesCommand extends Command
{
    protected $signature = 'episodes:remove-live';

    protected $description = 'Remove live from episodes';

    public function handle()
    {
        Episode::liveNow()->get()->each(function (Episode $episode) {
            $episode->update(['is_live_now' => false]);
        });
    }
}
