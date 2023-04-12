<?php

namespace Modules\Livestream\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Modules\Livestream\Models\LivestreamAccount;
use Spark\Events\SubscriptionCreated;

class EnableStream implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(SubscriptionCreated $event)
    {
        /** @var LivestreamAccount $livestreamAccount */
        $livestreamAccount = $event->billable->livestreamAccount;

        $livestreamAccount->defaultStream()->enable();
    }
}
