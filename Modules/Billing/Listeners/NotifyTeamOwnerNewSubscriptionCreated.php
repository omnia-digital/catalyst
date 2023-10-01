<?php

namespace Modules\Billing\Listeners;

use Modules\Billing\Events\TeamMemberSubscriptionCreatedEvent;
use Modules\Billing\Notifications\TeamMemberSubscriptionCreatedNotification;

class NotifyTeamOwnerNewSubscriptionCreated
{
    /**
     * Handle the event.
     *
     * @param  TeamMemberSubscriptionCreatedEvent  $event
     * @return void
     */
    public function handle($event)
    {
        $event->team->owner->notify(
            new TeamMemberSubscriptionCreatedNotification
        );
    }
}
