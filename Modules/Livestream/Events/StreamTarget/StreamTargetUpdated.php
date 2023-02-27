<?php

namespace App\Events\StreamTarget;

use App\Events\Event;

class StreamTargetUpdated extends Event
{
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
