<?php

namespace Modules\Livestream\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Modules\Livestream\Models\Episode;

class AddExpirationForEpisodesCommand extends Command
{
    protected $signature = 'episodes:add-exp {date}';

    protected $description = 'Add expiration for episodes that do not have expires_at.';

    public function handle()
    {
        $date = Carbon::parse($this->argument('date'));

        Episode::query()
            ->where(fn(Builder $query) => $query->whereNull('expires_at')->orWhere('expires_at', ''))
            ->get()
            ->each(function (Episode $episode) use ($date) {
                $episode->update(['expires_at' => $date]);
            });
    }
}
