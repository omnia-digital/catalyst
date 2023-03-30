<?php

namespace Modules\Livestream\Events\Stream;

use Illuminate\Queue\SerializesModels;
use Modules\Livestream\Events\Event;
use Modules\Livestream\Http\Requests\Notifications\StreamStartNotificationRequest;

class StreamStarted extends Event
{
    use SerializesModels;

    public $notificationRequest;

    /**
     * Create a new event instance.
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
