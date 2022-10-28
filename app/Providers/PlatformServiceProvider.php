<?php

namespace App\Providers;

use App\Support\Platform\Platform;
use App\Support\Platform\Translate;
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
            return new Platform();
        });
        App::bind('trans', function () {
            return new Translate();
        });
    }
}
