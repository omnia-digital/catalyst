<?php

namespace App\Events\Stream;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Http\Requests\Notifications\StreamStartNotificationRequest;

class StreamStarted extends Event
{
    use SerializesModels;

    public $notificationRequest;

    /**
     * Create a new event instance.
     *
     * @param StreamStartNotificationRequest $notificationRequest
     */
    public function __construct(StreamStartNotificationRequest $notificationRequest)
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
