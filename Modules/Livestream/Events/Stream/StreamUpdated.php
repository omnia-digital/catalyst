<?php

namespace Modules\Livestream\Events\Stream;

use Modules\Livestream\Events\Video\MuxEvent;

class StreamUpdated extends MuxEvent
{
    public $data;

    /**
     * Create a new event instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
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
