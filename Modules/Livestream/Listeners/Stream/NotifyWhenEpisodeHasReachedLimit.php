<?php

namespace App\Listeners\Stream;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use App\Events\Stream\StreamWasInterrupted;
use App\Notifications\StreamWasInterruptedNotification;

class NotifyWhenEpisodeHasReachedLimit
{
    /**
     * Handle the event.
     *
     * @param  StreamWasInterrupted  $event
     * @return void
     */
    public function handle(StreamWasInterrupted $event)
    {
        Notification::route('mail', $event->livestreamAccount->admin_email)
            //->route('slack', env('SLACK_WEBHOOK_APP_URL')) // We can send to Slack if needed.
            ->notify(new StreamWasInterruptedNotification(
                'Your limit of 1 Episode per week has been reached. Please upgrade to a paid plan if you need to stream more than 1 Episode per week'
            ));
    }
}
