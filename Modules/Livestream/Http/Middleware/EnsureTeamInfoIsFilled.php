<?php

namespace Modules\Livestream\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureTeamInfoIsFilled
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $team = $request->user()->currentTeam;

        if (!$team->hasInfoIsFilled()) {
            return redirect()->route('teams.show', [
                'team' => $team,
                'alert' => true,
            ]);
        }

        return $next($request);
    }
}
