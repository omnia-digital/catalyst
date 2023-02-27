<?php

namespace App\Listeners;

use App\Services\Plausible\Plausible;
use Spark\Events\SubscriptionCancelled;

class TrackSubscriptionCancelledGoalListener
{
    public function handle(SubscriptionCancelled $event)
    {
        app(Plausible::class)->dispatchCustomEvent(
            config('plausible.events.subscription-cancelled')
        );
    }
}
