<?php

namespace Modules\Social\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
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
    ];

    /**
     * @var string[]
     *
     * @psalm-var array{'Modules\\Social\\Models\\Post'::class: PostObserver::class}
     */
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
