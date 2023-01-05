<?php

namespace App\Providers;

use App\Http\Livewire\MainNavigationMenu;
use App\Settings\GeneralSettings;
use Filament\Facades\Filament;
use Filament\Navigation\UserMenuItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;
use Laravel\Cashier\Cashier;
use Nwidart\Modules\Module;
use Spatie\Health\Checks\Checks\DatabaseCheck;
use Spatie\Health\Checks\Checks\UsedDiskSpaceCheck;
use Spatie\Health\Health;

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

//        Health::checks([
//            UsedDiskSpaceCheck::new(),
//            DatabaseCheck::new()
//        ]);

        Filament::serving(function () {
            Filament::registerTheme(asset('css/app.css'),);
            Filament::registerUserMenuItems([
                // ...
                'logout' => UserMenuItem::make()
                                        ->label('Log out')
                                        ->url(route('logout')),
            ]);
        });
    }
}
