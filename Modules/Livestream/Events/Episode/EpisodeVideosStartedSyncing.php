<?php

namespace Modules\Livestream\Events\Episode;

use Modules\Livestream\Episode;
use Modules\Livestream\Events\Event;

class EpisodeVideosStartedSyncing extends Event
{
    public $episode;

    /**
     * Create a new event instance.
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
