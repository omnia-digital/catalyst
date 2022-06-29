<?php

namespace App\Providers;

use App\Util\Platform\Translate;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class PlatformTranslateServiceProvider extends ServiceProvider
{
    public function boot()
    {
    }

    public function register()
    {
        App::bind('trans', function () {
            return new Translate();
        });
    }
}
