<?php namespace Modules\Livestream\Providers;

use Modules\Livestream\Events\StreamActive;
use Modules\Livestream\Events\StreamCompleted;
use Modules\Livestream\Events\StreamIdle;
use Modules\Livestream\Events\VideoAssetReady;
use Modules\Livestream\Listeners\MarkStreamIdle;
use Modules\Livestream\Listeners\NotifyStreamStarted;
use Modules\Livestream\Listeners\SaveMuxAsset;
use Modules\Livestream\Listeners\UpdateEpisodeInfo;
use Modules\Livestream\Services\Mux\MuxAsset;
use Modules\Livestream\Services\Mux\MuxDeliveryUsage;
use Modules\Livestream\Services\Mux\MuxLivestream;
use Modules\Livestream\Services\Mux\MuxUploader;
use Modules\Livestream\Services\Mux\MuxVideoView;
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
