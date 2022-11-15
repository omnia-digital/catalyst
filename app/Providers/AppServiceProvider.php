<?php

namespace App\Providers;

use App\Settings\GeneralSettings;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;
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
        Cashier::ignoreMigrations();
        //Model::preventLazyLoading(! $this->app->isProduction());
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Cashier::calculateTaxes();

        Filament::serving(function () {
            
            Filament::registerTheme(
                asset('css/filament.css'),
            );
        });
    }
}
