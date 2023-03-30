<?php

namespace Modules\Livestream\Actions\Episodes;

use Carbon\Carbon;
use Modules\Livestream\Models\Team;

class GetTotalEpisodeViewsAction
{
    public function execute(Carbon $from, Carbon $to, bool $expiredOnly = true, ?Team $team = null): int|float
    {
        is_null($team) && $team = auth()->user()->currentTeam;

        // For normal episodes, get all episodes to calculate the attachment downloads count.
        if ($expiredOnly) {
            $views = $team->livestreamAccount->episodes()->expired()->whereVideoViewsInDateRange($from, $to)->get()->sum('video_views_count');
        } else {
            $views = $team->livestreamAccount->episodes()->whereVideoViewsInDateRange($from, $to)->get()->sum('video_views_count');
        }

        return $views;
    }
}
