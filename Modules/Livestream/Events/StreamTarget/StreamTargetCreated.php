<?php

namespace Modules\Livestream\Events\StreamTarget;

use Modules\Livestream\Events\Event;

class StreamTargetCreated extends Event
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