<?php

namespace App\Providers;

use App\Contracts\Events\ContributesToUserScore;
use App\Events\BaseEvent;
use App\Models\Membership;
use App\Models\Team;
use App\Models\User;
use App\Observers\MembershipObserver;
use App\Observers\TeamObserver;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

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
        Event::listen(function (BaseEvent $event) {
            if (interface_exists(ContributesToUserScore::class)) {
                $classInterfaces = class_implements($event);
                $implementsClass = in_array(ContributesToUserScore::class, $classInterfaces);
                if ($implementsClass) {
                    $event->trackContributionToUserScore();
                }
            }
        });
    }
}
