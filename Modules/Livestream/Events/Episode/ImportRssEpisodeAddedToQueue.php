<?php

namespace App\Events\Episode;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Http\Requests\Notifications\StreamEndNotificationRequest;

class ImportRssEpisodeAddedToQueue extends Event
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
