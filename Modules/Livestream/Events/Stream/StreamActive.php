<?php

namespace App\Events\Stream;

use App\Events\Video\MuxEvent;

class StreamActive extends MuxEvent
{
    public $data;
    public $stream_id;

    /**
     * Create a new event instance.
     *
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
        $this->stream_id = $data['data']['id'];
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
