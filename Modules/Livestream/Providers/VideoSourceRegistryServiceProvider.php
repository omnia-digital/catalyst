<?php

namespace Modules\Livestream\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Livestream\Registries\VideoSource\FromUrlSource;
use Modules\Livestream\Registries\VideoSource\MuxVideoSource;
use Modules\Livestream\Registries\VideoSource\S3VideoSource;
use Modules\Livestream\Registries\VideoSource\VideoSourceRegistry;

class VideoSourceRegistryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->singleton(VideoSourceRegistry::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        $this->app->make(VideoSourceRegistry::class)
            ->register(3, new MuxVideoSource)
            ->register(6, new S3VideoSource)
            ->register(7, new FromUrlSource);
    }
}
