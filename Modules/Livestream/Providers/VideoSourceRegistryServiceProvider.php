<?php namespace Modules\Livestream\Providers;

use Modules\Livestream\Registries\VideoSource\FromUrlSource;
use Modules\Livestream\Registries\VideoSource\MuxVideoSource;
use Modules\Livestream\Registries\VideoSource\S3VideoSource;
use Modules\Livestream\Registries\VideoSource\VideoSourceRegistry;
use Illuminate\Support\ServiceProvider;

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
