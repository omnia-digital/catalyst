<?php

namespace Modules\Jobs\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OnlyClient
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->hasRole('Client')) {
            return $next($request);
        }

        abort(403, 'This resource is only available for Client users.');
    }
}
