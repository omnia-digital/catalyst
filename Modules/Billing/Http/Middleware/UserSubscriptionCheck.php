<?php

namespace Modules\Billing\Http\Middleware;

use App\Settings\BillingSettings;
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
        if (!(new BillingSettings())->user_subscriptions) {
            return $next($request);
        }

        if ($request->user()->chargentSubscription()?->latest()?->first()?->is_active) {
            return $next($request);
        }

        return redirect()->route('social.subscription');

    }
}
