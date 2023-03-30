<?php

namespace Modules\Livestream\Events\Video;

use Modules\Livestream\Events\Event;

class LiveVideosProcessingAddedToQueue extends Event
{
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
