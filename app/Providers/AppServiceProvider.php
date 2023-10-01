<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Cashier::ignoreMigrations();
        Model::preventLazyLoading(app()->isLocal());
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //Cashier::calculateTaxes();

        //        Health::checks([
        //            UsedDiskSpaceCheck::new(),
        //            DatabaseCheck::new()
        //        ]);

        // Mailcoach UI Auth
        //        Gate::define('viewMailcoach', function ($user = null) {
        //            return optional($user)->is_admin;
        //        });

        //                Filament::serving(function () {
        //        //            Filament::registerTheme(asset('css/app.css'));
        //                                Filament::registerUserMenuItems([
        //                                    // ...
        //                                    'logout' => UserMenuItem::make()
        //                                                            ->label('Log out')
        //                                                            ->url(route('logout')),
        //                                ]);
        //                });
    }
}
