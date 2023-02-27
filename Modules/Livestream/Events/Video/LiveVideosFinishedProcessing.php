<?php

namespace Modules\Livestream\Events\Video;

use Modules\Livestream\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Modules\Livestream\Services\EpisodeService;

class LiveVideosFinishedProcessing extends Event
{

    public $episodeService;

    /**
     * Create a new event instance.
     * @param EpisodeService $episodeService
     */
    public function __construct(EpisodeService $episodeService)
    {
        $this->episodeService = $episodeService;
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
