<?php

namespace Modules\Livestream\Actions\Episodes;

use Carbon\Carbon;
use Modules\Livestream\Models\Team;

class GetTotalNumberOfEpisodesAction
{
    public function execute(Carbon $from, Carbon $to, bool $expiredOnly = true, ?Team $team = null): int|float
    {
        is_null($team) && $team = auth()->user()->currentTeam;

        // For normal episodes, get the total number of episodes count.
        if ($expiredOnly) {
            $numberOfEpisodes = $team->livestreamAccount->episodes()->expired()->whereBetween('created_at', [$from, $to])->count();
        } else {
            $numberOfEpisodes = $team->livestreamAccount->episodes()->whereBetween('created_at', [$from, $to])->count();
        }

        return $numberOfEpisodes;
    }
}
