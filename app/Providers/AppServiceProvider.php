<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\UserMenuItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;
use Spatie\Health\Checks\Checks\DatabaseCheck;
use Spatie\Health\Checks\Checks\UsedDiskSpaceCheck;
use Spatie\Health\Health;
use Trans;

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
        Model::preventLazyLoading(app()->isLocal());
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Cashier::calculateTaxes();

        //        Health::checks([
        //            UsedDiskSpaceCheck::new(),
        //            DatabaseCheck::new()
        //        ]);

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
