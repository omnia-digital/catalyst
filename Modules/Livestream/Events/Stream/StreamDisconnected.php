<?php

namespace Modules\Livestream\Events\Stream;

use Modules\Livestream\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Modules\Livestream\Events\Video\MuxEvent;
use Modules\Livestream\Services\EpisodeService;

class StreamDisconnected extends MuxEvent
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
