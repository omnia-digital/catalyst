<?php

namespace Modules\Billing\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Billing\Models\ChargentSubscription;

class NewSubscriptionPayment
{
    use Dispatchable, SerializesModels;

    /**
     * @var ChargentSubscription
     */
    public $subscription;

    /**
     * Create a new event instance.
     *
     * @param ChargentSubscription $subscription
     */
    public function __construct(ChargentSubscription $subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
