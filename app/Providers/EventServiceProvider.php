<?php

namespace App\Providers;

use OmniaDigital\CatalystCore\Models\Membership;
use App\Models\Team;
use App\Models\User;
use OmniaDigital\CatalystCore\Observers\MembershipObserver;
use Illuminate\Auth\Events\Registered;
use OmniaDigital\CatalystCore\Observers\TeamObserver;
use OmniaDigital\CatalystCore\Observers\UserObserver;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $observers = [
        Team::class => [TeamObserver::class],
        User::class => [UserObserver::class],
        Membership::class => [MembershipObserver::class],
    ];
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
