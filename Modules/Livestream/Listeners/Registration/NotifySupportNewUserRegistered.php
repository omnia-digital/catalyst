<?php

namespace Modules\Livestream\Listeners\Registration;

use Modules\Livestream\Omnia;
use Illuminate\Support\Facades\Mail;
use Laravel\Spark\Events\Auth\UserRegistered;
use Laravel\Spark\Interactions\Support\SendSupportEmail;

class NotifySupportNewUserRegistered
{

    /**
     * Handle the event.
     *
     * @param  UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        $emailData = [
            'from' => $event->user->email,
            'subject' => 'New User Registered',
            'user' => $event->user
        ];

        Omnia::interact(SendSupportEmail::class, [$emailData, 'auth.emails.new-user-registered']);
    }
}
