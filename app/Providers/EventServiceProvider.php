<?php

namespace App\Providers;

use App\Models\Team;
use App\Models\User;
use App\Observers\TeamObserver;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * @var string[][]
     *
     * @psalm-var array{'App\\Models\\Team'::class: array{0: TeamObserver::class}, 'App\\Models\\User'::class: array{0: UserObserver::class}}
     */
    protected $observers = [
        Team::class => [TeamObserver::class,],
        User::class => [UserObserver::class,],
    ];

    /**
     * @var string[][]
     *
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    public function boot()
    {
        //
    }
}
