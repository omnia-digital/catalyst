<?php

namespace Modules\Jobs\Listeners;

use Illuminate\Auth\Events\Registered;

class CreateStripeCustomer
{
    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(Registered $event)
    {
        $event->user->createAsStripeCustomer();
    }
}
