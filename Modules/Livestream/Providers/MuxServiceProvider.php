<?php namespace App\Providers;

use App\Events\StreamActive;
use App\Events\StreamCompleted;
use App\Events\StreamIdle;
use App\Events\VideoAssetReady;
use App\Listeners\MarkStreamIdle;
use App\Listeners\NotifyStreamStarted;
use App\Listeners\SaveMuxAsset;
use App\Listeners\UpdateEpisodeInfo;
use App\Services\Mux\MuxAsset;
use App\Services\Mux\MuxDeliveryUsage;
use App\Services\Mux\MuxLivestream;
use App\Services\Mux\MuxUploader;
use App\Services\Mux\MuxVideoView;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use MuxPhp\Configuration;

class MuxServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        // Register Mux services
        $config = Configuration::getDefaultConfiguration()
            ->setUsername(config('services.mux.token_id'))
            ->setPassword(config('services.mux.token_secret'));

        $this->app->singleton(MuxAsset::class, fn() => new MuxAsset(new Client, $config));
        $this->app->singleton(MuxUploader::class, fn() => new MuxUploader(new Client, $config));
        $this->app->singleton(MuxDeliveryUsage::class, fn() => new MuxDeliveryUsage(new Client, $config));
        $this->app->singleton(MuxLivestream::class, fn() => new MuxLivestream(new Client, $config));
        $this->app->singleton(MuxVideoView::class, fn() => new MuxVideoView(new Client, $config));

        // Register Mux Events for webhooks
        Event::listen(VideoAssetReady::class, SaveMuxAsset::class);
        Event::listen(StreamActive::class, NotifyStreamStarted::class);
        Event::listen(StreamIdle::class, MarkStreamIdle::class);
        Event::listen(StreamCompleted::class, UpdateEpisodeInfo::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        //
    }
}
