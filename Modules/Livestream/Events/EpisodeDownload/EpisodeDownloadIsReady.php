<?php

namespace Modules\Livestream\Events\EpisodeDownload;

use Illuminate\Queue\SerializesModels;
use Modules\Livestream\EpisodeDownload;
use Modules\Livestream\Events\Event;

class EpisodeDownloadIsReady extends Event
{
    use SerializesModels;

    /**
     * @var EpisodeDownload
     */
    public $episodeDownload;

    /**
     * Create a new event instance.
     */
    public function __construct(EpisodeDownload $episodeDownload)
    {
        $this->episodeDownload = $episodeDownload;
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
