<?php

namespace Modules\Subscriptions\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserSubscriptionCheck
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
        if ($request->user()->chargentSubscription?->is_active) {
            return $next($request);
        }

        return redirect()->route('social.subscription');
        
    }
}
