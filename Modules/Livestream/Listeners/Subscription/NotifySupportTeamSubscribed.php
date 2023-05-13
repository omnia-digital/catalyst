<?php

namespace Modules\Livestream\Listeners\Subscription;

use Exception;
use Laravel\Spark\Events\Teams\Subscription\TeamSubscribed;
use Laravel\Spark\Interactions\Support\SendSupportEmail;
use Modules\Livestream\Omnia;

class NotifySupportTeamSubscribed
{
    /**
     * Handle the event.
     */
    public function handle(TeamSubscribed $event)
    {
        try {
            $emailData = [
                'from' => $event->team->owner->email,
                'subject' => 'Organization Subscribed to plan: ' . $event->plan->name,
                'plan' => $event->plan,
            ];

//        Omnia::interact(SendSupportEmail::class, [$emailData, 'auth.emails.team-subscribed']);
        } catch (Exception $e) {
            return;
        }
    }
}
