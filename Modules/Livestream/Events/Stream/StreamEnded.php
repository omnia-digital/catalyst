<?php

namespace Modules\Livestream\Events\Stream;

use Modules\Livestream\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Modules\Livestream\Http\Requests\Notifications\StreamEndNotificationRequest;

class StreamEnded extends Event
{
    use SerializesModels;

    public $notificationRequest;

    /**
     * Create a new event instance.
     *
     * @param StreamEndNotificationRequest $notificationRequest
     */
    public function __construct(StreamEndNotificationRequest $notificationRequest)
    {
        $this->notificationRequest = $notificationRequest;
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