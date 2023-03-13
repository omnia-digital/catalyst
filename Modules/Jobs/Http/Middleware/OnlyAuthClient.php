<?php

namespace Modules\Jobs\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OnlyAuthClient
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Guest still has access
        // If a user logged in, he must be a Client to have access.
        if (Auth::guest() || $request->user()->hasRole('Client')) {
            return $next($request);
        }

        abort(403, 'This resource is only available for Client users.');
    }
}
