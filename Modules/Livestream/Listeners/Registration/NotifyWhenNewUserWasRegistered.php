<?php

namespace App\Listeners\Registration;

use App\Notifications\NewUserWasRegisteredNotification;
use App\Omnia;
use Laravel\Spark\Events\Auth\UserRegistered;
use App\User;

class NotifyWhenNewUserWasRegistered
{
    /**
     * Handle the event.
     *
     * @param  UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        $systemAdminUser = User::where('email',Omnia::$systemAdminUser)->first();
        $systemAdminUser->slack_webhook_url = env('SLACK_WEBHOOK_APP_URL');
        $systemAdminUser->save();

        $systemAdminUser->notify(new NewUserWasRegisteredNotification(
            'A new user was registered at '
            . $event->user->created_at . ' with email '
            . $event->user->email
        ));
    }
}
