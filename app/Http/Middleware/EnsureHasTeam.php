<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureHasTeam
{


    protected function ensureUserHasCurrentTeamSet(): void
    {
        if (is_null(auth()->user()->current_team_id)) {
            $user = auth()->user();
            $user->current_team_id = $user->teams()->first()->id;
            $user->save();
        }
    }
}
