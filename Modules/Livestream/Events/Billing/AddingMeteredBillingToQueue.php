<?php

namespace Modules\Livestream\Events\Billing;

use Modules\Livestream\Events\Event;

class AddingMeteredBillingToQueue extends Event
{
    public $team;
    public $invoiceId;
    public $subscriptionId;

    public function __construct($team, $invoiceId, $subscriptionId)
    {
        $this->team = $team;
        $this->invoiceId = $invoiceId;
        $this->subscriptionId = $subscriptionId;
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
