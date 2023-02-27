<?php

namespace App\Events\Episode;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use App\Services\EpisodeService;

class EpisodeFinishedRecording extends Event
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
