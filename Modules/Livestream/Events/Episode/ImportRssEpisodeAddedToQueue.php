<?php

namespace Modules\Livestream\Events\Episode;

use Illuminate\Queue\SerializesModels;
use Modules\Livestream\Events\Event;

class ImportRssEpisodeAddedToQueue extends Event
{
    use SerializesModels;

    public $episode;

    /**
     * Create a new event instance.
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
