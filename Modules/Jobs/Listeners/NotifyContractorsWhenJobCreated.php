<?php

namespace Modules\Jobs\Listeners;

use Modules\Jobs\Events\JobPositionWasCreated;
use Modules\Jobs\Notifications\JobPositionWasCreatedNotification;
use Modules\Jobs\Support\Notification\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyContractorsWhenJobCreated implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param JobPositionWasCreated $event
     * @return void
     */
    public function handle(JobPositionWasCreated $event)
    {
        Notification::make(new JobPositionWasCreatedNotification($event->job))->toContractors();
    }
}
