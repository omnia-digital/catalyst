<?php

namespace Modules\Livestream\Listeners\Subscription;

use Modules\Livestream\Omnia;
use Illuminate\Support\Facades\Mail;
use Laravel\Spark\Events\Auth\UserRegistered;
use Laravel\Spark\Events\Teams\Subscription\TeamSubscribed;
use Laravel\Spark\Interactions\Support\SendSupportEmail;

class NotifySupportTeamSubscribed
{

	/**
	 * Handle the event.
	 *
	 * @param TeamSubscribed $event
	 */
    public function handle(TeamSubscribed $event)
    {
	    try {
		    $emailData = [
			    'from'    => $event->team->owner->email,
			    'subject' => 'Organization Subscribed to plan: ' . $event->plan->name,
			    'plan'    => $event->plan
		    ];

//        Omnia::interact(SendSupportEmail::class, [$emailData, 'auth.emails.team-subscribed']);
	    } catch(\Exception $e) {
		    return;
	    }
    }
}
