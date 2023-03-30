<?php

namespace Modules\Social\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Modules\Billing\Events\NewSubscriptionPayment;
use Modules\Social\Models\Post;
use Modules\Social\Observers\PostObserver;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        NewSubscriptionPayment::class => [
        ],
    ];

    protected $observers = [
        Post::class => PostObserver::class,
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
