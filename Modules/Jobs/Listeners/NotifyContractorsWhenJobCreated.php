<?php

namespace Modules\Jobs\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Modules\Jobs\Events\JobPositionWasCreated;
use Modules\Jobs\Notifications\JobPositionWasCreatedNotification;
use Modules\Jobs\Support\Notification\Notification;

class NotifyContractorsWhenJobCreated implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(JobPositionWasCreated $event)
    {
        Notification::make(new JobPositionWasCreatedNotification($event->job))->toContractors();
    }
}
