<?php

namespace Modules\Livestream\Events\Episode;

use Illuminate\Queue\SerializesModels;
use Modules\Livestream\Events\Event;

class EpisodeStartedRecording extends Event
{
    use SerializesModels;

    public $episode;
    public $LivestreamAccount;
    public $realStreamName;

    /**
     * Create a new event instance.
     */
    public function __construct($episode, $LivestreamAccount, $realStreamName)
    {
        $this->episode = $episode;
        $this->LivestreamAccount = $LivestreamAccount;
        $this->realStreamName = $realStreamName;
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
