<?php

namespace Modules\Billing\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Billing\Events\TeamMemberSubscriptionCreatedEvent;
use Modules\Billing\Listeners\NotifyTeamOwnerNewSubscriptionCreated;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        TeamMemberSubscriptionCreatedEvent::class => [
            NotifyTeamOwnerNewSubscriptionCreated::class,
        ],
    ];
}
