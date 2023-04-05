<?php

namespace App\Listeners;

use App\Events\UserRegistered;

class SendUserRegistered
{
    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle($event)
    {
        event(new UserRegistered($event->user));
    }
}
