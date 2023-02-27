<?php

namespace App\Events\Episode;

use App\Episode;
use App\Events\Event;

class EpisodeVideosFinishedSyncing extends Event
{
    public $episode;

    /**
     * Create a new event instance.
     *
     * @param $episode
     */
    public function __construct(Episode $episode)
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
