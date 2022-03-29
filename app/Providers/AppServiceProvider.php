<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Nwidart\Modules\Module;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //Model::preventLazyLoading(! $this->app->isProduction());

        Module::macro('isModuleEnabled', function ($moduleName) {
            if (Module::collections()->has($moduleName)) {
                $module = Module::find($moduleName);
                return $module->isStatus(1);
            }

            return false;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
