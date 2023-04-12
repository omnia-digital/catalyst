<?php

namespace Modules\Livestream\Listeners\Registration;

use Laravel\Spark\Events\Auth\UserRegistered;
use Laravel\Spark\Interactions\Support\SendSupportEmail;
use Modules\Livestream\Omnia;

class NotifySupportNewUserRegistered
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
            'subject' => 'New User Registered',
            'user' => $event->user,
        ];

        Omnia::interact(SendSupportEmail::class, [$emailData, 'auth.emails.new-user-registered']);
    }
}
