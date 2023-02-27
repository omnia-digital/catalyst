<?php

namespace Modules\Livestream\Listeners;

use Modules\Livestream\Jobs\CreateStripeCustomerJob;
use Modules\Livestream\Jobs\CreateStripeMeteredSubscriptionJob;
use Illuminate\Support\Facades\Bus;
use Laravel\Jetstream\Events\TeamUpdated;

class CreateStripeStuffOnTheFirstTeamUpdatedListener
{
    public function handle(TeamUpdated $event)
    {
        // If team already had Stripe customer id, just skip it.
        if ($event->team->stripe_id) {
            return;
        }

        Bus::chain([
            new CreateStripeCustomerJob($event->team),
            new CreateStripeMeteredSubscriptionJob($event->team)
        ])->dispatch();
    }
}
