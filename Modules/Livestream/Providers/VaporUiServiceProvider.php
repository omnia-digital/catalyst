<?php

namespace Modules\Livestream\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Modules\Livestream\Omnia;

class VaporUiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->gate();
    }

    /**
     * Register the Vapor UI gate.
     *
     * This gate determines who can access Vapor UI in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewVaporUI', function ($user = null) {
            return true;
            //return in_array(optional($user)->email, Omnia::adminEmails());
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
