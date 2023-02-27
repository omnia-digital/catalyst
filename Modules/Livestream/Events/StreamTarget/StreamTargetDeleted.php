<?php

namespace App\Events\StreamTarget;

use App\Events\Event;

class StreamTargetDeleted extends Event
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
