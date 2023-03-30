<?php

namespace App\Providers;

use App\Models\Membership;
use App\Models\Team;
use App\Models\User;
use App\Observers\MembershipObserver;
use App\Observers\TeamObserver;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $observers = [
        Team::class => [TeamObserver::class],
        User::class => [UserObserver::class],
        Membership::class => [MembershipObserver::class],
    ];

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
