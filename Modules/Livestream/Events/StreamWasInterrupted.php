<?php

namespace Modules\Livestream\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StreamWasInterrupted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $streamEvent;

    public $livestreamAccount;

    /**
     * Create a new event instance.
     */
    public function __construct($streamEvent, $livestreamAccount)
    {
        $this->streamEvent = $streamEvent;
        $this->livestreamAccount = $livestreamAccount;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
