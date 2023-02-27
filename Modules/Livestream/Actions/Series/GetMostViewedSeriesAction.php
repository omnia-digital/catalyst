<?php namespace App\Actions\Series;

use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class GetMostViewedSeriesAction
{
    /**
     * @param Carbon $from
     * @param Carbon $to
     * @param Team|null $team
     * @return Model
     */
    public function execute(Carbon $from, Carbon $to, bool $expiredOnly = true, ?Team $team = null): Model|null
    {
        is_null($team) && $team = Auth::user()->currentTeam;

        return $team->livestreamAccount->series->each(function ($series) use ($from, $to) {
            return $series->most_views = $series->getTotalEpisodeViewsByDateRange($from, $to);
        })->sortByDesc('most_views')->first();
    }
}
