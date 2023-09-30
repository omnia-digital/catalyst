<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Navigation\NavigationGroup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;
use Trans;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        Cashier::ignoreMigrations();
        Model::preventLazyLoading(app()->isLocal());
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
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

        Filament::serving(function () {
            Filament::registerTheme(asset('css/app.css'));
            //            Filament::registerUserMenuItems([
            //                // ...
            //                'logout' => UserMenuItem::make()
            //                                        ->label('Log out')
            //                                        ->url(route('logout')),
            //            ]);
            Filament::registerNavigationGroups([
                NavigationGroup::make()
                    ->label(Trans::get('Settings'))
                    ->icon('heroicon-s-cog')
                    ->collapsed(),
                NavigationGroup::make()
                    ->label(Trans::get('Billing'))
                    ->icon('heroicon-o-credit-card')
                    ->collapsed(),
                NavigationGroup::make()
                    ->label(Trans::get('People'))
                    ->icon('heroicon-s-users')
                    ->collapsed(),
                NavigationGroup::make()
                    ->label(Trans::get('Teams'))
                    ->icon('fas-users')
                    ->collapsed(),
                NavigationGroup::make()
                    ->label(Trans::get('Forms'))
                    ->icon('fab-wpforms')
                    ->collapsed(),
                NavigationGroup::make()
                    ->label(Trans::get('Feeds'))
                    ->icon('fad-rss')
                    ->collapsed(),
                NavigationGroup::make()
                    ->label(Trans::get('Games'))
                    ->icon('fad-gamepad-modern')
                    ->collapsed(),

            ]);
        });
    }
}
