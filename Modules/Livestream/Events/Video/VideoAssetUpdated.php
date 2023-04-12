<?php

namespace Modules\Livestream\Events\Video;

use Modules\Livestream\Events\Event;

class VideoAssetUpdated extends MuxEvent
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
