<?php

namespace Modules\Livestream\Actions\Series;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Modules\Livestream\Models\Team;

class GetMostViewedSeriesAction
{
    /**
     * @return Model
     */
    public function execute(Carbon $from, Carbon $to, bool $expiredOnly = true, ?Team $team = null): Model|null
    {
        is_null($team) && $team = auth()->user()->currentTeam;

        return $team->livestreamAccount->series->each(function ($series) use ($from, $to) {
            return $series->most_views = $series->getTotalEpisodeViewsByDateRange($from, $to);
        })->sortByDesc('most_views')->first();
    }
}
