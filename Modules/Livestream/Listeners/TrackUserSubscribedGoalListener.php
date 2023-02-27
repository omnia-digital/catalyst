<?php

namespace App\Listeners;

use App\Services\Plausible\Plausible;
use Spark\Events\SubscriptionCreated;

class TrackUserSubscribedGoalListener
{
    public function handle(SubscriptionCreated $event)
    {
        app(Plausible::class)->dispatchCustomEvent(config('plausible.events.user-subscribed'), [
            'plan' => $event->billable->subscription()->stripe_plan
        ]);
    }
}
