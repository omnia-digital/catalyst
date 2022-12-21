<?php

namespace App\Providers;

use App\Support\Platform\Platform;
use App\Support\StripeConnect\StripeConnect;
use Illuminate\Support\ServiceProvider;

class StripeConnectServiceProvider extends ServiceProvider
{
    public function register()
    {
        if (Platform::isUsingStripe()) {
            $this->app->singleton(StripeConnect::class, function () {
                return new StripeConnect(secret: config('services.stripe.secret'), refreshUrl: route('teams.stripe-connect.refresh'),);
            });
        }
    }

    public function boot()
    {
    }
}
