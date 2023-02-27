<?php namespace App\Providers;

use App\Registries\VideoSource\FromUrlSource;
use App\Registries\VideoSource\MuxVideoSource;
use App\Registries\VideoSource\S3VideoSource;
use App\Registries\VideoSource\VideoSourceRegistry;
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
