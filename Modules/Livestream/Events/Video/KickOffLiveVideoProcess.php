<?php

namespace Modules\Livestream\Events\Video;

use Modules\Livestream\Events\Event;
use Modules\Livestream\Services\EpisodeService;

/**
 * Class KickOffLiveVideoProcess
 */
class KickOffLiveVideoProcess extends Event
{
    public $episodeService;

    /**
     * Create a new event instance.
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
