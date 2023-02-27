<?php

namespace Modules\Livestream\Events\Episode;

use Modules\Livestream\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Modules\Livestream\Http\Requests\Notifications\StreamEndNotificationRequest;

class ImportRssEpisodeFinished extends Event
{
    use SerializesModels;

    public $episode;

    /**
     * Create a new event instance.
     *
     * @param $episode
     */
    public function __construct($episode)
    {
        $this->episode = $episode;
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
