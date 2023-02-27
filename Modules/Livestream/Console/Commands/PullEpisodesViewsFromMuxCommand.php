<?php

namespace App\Console\Commands;

use App\Jobs\PullEpisodeViewsFromMuxJob;
use App\Models\Episode;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

class PullEpisodesViewsFromMuxCommand extends Command
{
    protected $signature = 'episodes:pull-views';

    protected $description = 'Pull views of episodes from Mux.';

    public function handle()
    {
        Episode::query()
            ->shouldPullViewsFromMux()
            ->chunk(100, function (Collection $episodes) {
                $episodes->each(function (Episode $episode) {
                    dispatch(new PullEpisodeViewsFromMuxJob($episode));
                });
            });
    }
}
