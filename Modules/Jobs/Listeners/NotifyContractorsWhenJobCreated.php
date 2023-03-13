<?php

namespace Modules\Jobs\Listeners;

use Modules\Jobs\Events\JobWasCreated;
use Modules\Jobs\Notifications\JobWasCreatedNotification;
use Modules\Jobs\Support\Notification\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyContractorsWhenJobCreated implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param JobWasCreated $event
     * @return void
     */
    public function handle(JobWasCreated $event)
    {
        Notification::make(new JobWasCreatedNotification($event->job))->toContractors();
    }
}
