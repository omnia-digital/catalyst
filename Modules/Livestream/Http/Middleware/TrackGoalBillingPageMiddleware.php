<?php

namespace Modules\Livestream\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Livestream\Services\Plausible\Plausible;

class TrackGoalBillingPageMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->path() === config('spark.path')) {
            app(Plausible::class)->dispatchCustomEvent(config('plausible.events.subscription-page-visited'));
        }

        return $next($request);
    }
}
