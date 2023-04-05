<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use Illuminate\Auth\Events\Verified;

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
