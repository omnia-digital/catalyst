<?php

namespace App\Providers;

use App\Util\Platform\Terms;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class PlatformTermsServiceProvider extends ServiceProvider
{
    public function boot()
    {
    }

    public function register()
    {
        App::bind('terms', function () {
            return new Terms();
        });
    }
}
