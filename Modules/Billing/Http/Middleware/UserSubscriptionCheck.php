<?php

namespace Modules\Billing\Http\Middleware;

use OmniaDigital\CatalystCore\Facades\Catalyst;
use Closure;
use Illuminate\Http\Request;

class UserSubscriptionCheck
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (! Catalyst::isUsingUserSubscriptions()) {
            return $next($request);
        }

        if ($request->user()->chargentSubscription()?->latest()?->first()?->is_active) {
            return $next($request);
        }

        return redirect()->route('billing.chargent-billing');
    }
}
