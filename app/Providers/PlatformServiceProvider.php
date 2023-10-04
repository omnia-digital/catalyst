<?php

namespace App\Providers;

use OmniaDigital\CatalystCore\Facades\Catalyst;
use App\Support\Catalyst\Translate;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class PlatformServiceProvider extends ServiceProvider
{
    public function boot()
    {
    }

    public function register()
    {
        App::bind('platform', function () {
            return new Catalyst;
        });
        App::bind('trans', function () {
            return new Translate;
        });
    }
}
