<?php

namespace App\Listeners\Subscription;

use App\Omnia;
use Illuminate\Support\Facades\Mail;
use Laravel\Spark\Events\Auth\UserRegistered;
use Laravel\Spark\Interactions\Support\SendSupportEmail;

class NotifySupportUserSubscribed
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
            'subject' => 'User Subscribed to plan: ' . $event->plan,
            'user' => $event->user,
            'plan' => $event->plan
        ];

        Omnia::interact(SendSupportEmail::class, [$emailData, 'auth.emails.user-subscribed']);
    }
}
