<?php

namespace App\Events\EpisodeDownload;

use App\EpisodeDownload;
use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class EpisodeDownloadIsReady extends Event
{
    use SerializesModels;

    /**
     * @var EpisodeDownload
     */
    public $episodeDownload;

    /**
     * Create a new event instance.
     *
     * @param EpisodeDownload $episodeDownload
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
