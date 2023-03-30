<?php

namespace Modules\Livestream\Listeners\Subscription;

use Laravel\Spark\Events\Auth\UserRegistered;
use Laravel\Spark\Interactions\Support\SendSupportEmail;
use Modules\Livestream\Omnia;

class NotifySupportUserSubscribed
{
    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        $emailData = [
            'from' => $event->user->email,
            'subject' => 'User Subscribed to plan: ' . $event->plan,
            'user' => $event->user,
            'plan' => $event->plan,
        ];

        Omnia::interact(SendSupportEmail::class, [$emailData, 'auth.emails.user-subscribed']);
    }
}
