<?php namespace Modules\Livestream\Actions\Episodes;

use Modules\Livestream\Models\Team;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class GetTotalEpisodeViewsAction
{
    /**
     * @param Carbon $from
     * @param Carbon $to
     * @param Team|null $team
     * @return int|float
     */
    public function execute(Carbon $from, Carbon $to, bool $expiredOnly = true, ?Team $team = null): int|float
    {
        is_null($team) && $team = Auth::user()->currentTeam;

        // For normal episodes, get all episodes to calculate the attachment downloads count.
        if ($expiredOnly) {
            $views = $team->livestreamAccount->episodes()->expired()->whereVideoViewsInDateRange($from, $to)->get()->sum('video_views_count');
        } else {
            $views = $team->livestreamAccount->episodes()->whereVideoViewsInDateRange($from, $to)->get()->sum('video_views_count');
        }

        return $views;
    }
}
