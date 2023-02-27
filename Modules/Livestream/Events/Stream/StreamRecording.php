<?php

namespace App\Events\Stream;

use App\Events\Video\MuxEvent;

class StreamRecording extends MuxEvent
{
    public $data;

    /**
     * Create a new event instance.
     *
     * @param $data
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
