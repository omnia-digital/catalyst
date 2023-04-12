<?php

namespace Modules\Jobs\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Jobs\Google\Client;

class GoogleServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     */
    public function boot()
    {
        if (function_exists('config_path')) {
            $this->publishes([
                __DIR__ . '/../../config/google.php' => config_path('google.php'),
            ], 'config');
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/google.php', 'google');

        $this->app->bind('Modules\Jobs\Google\Client', function ($app) {
            return new Client($app['config']['google']);
        });
    }
}
