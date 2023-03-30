<?php

namespace Modules\Livestream\Listeners;

use Modules\Livestream\Models\LivestreamAccount;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Spark\Events\SubscriptionCreated;

class EnableStream implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param SubscriptionCreated $event
     * @return void
     */
    public function handle(SubscriptionCreated $event)
    {
        /** @var LivestreamAccount $livestreamAccount */
        $livestreamAccount = $event->billable->livestreamAccount;

        $livestreamAccount->defaultStream()->enable();
    }
}
