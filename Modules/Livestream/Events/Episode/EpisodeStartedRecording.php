<?php

namespace Modules\Livestream\Events\Episode;

use Modules\Livestream\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Modules\Livestream\Http\Requests\Notifications\StreamEndNotificationRequest;

class EpisodeStartedRecording extends Event
{
    use SerializesModels;

    public $episode;
    public $LivestreamAccount;
    public $realStreamName;

    /**
     * Create a new event instance.
     *
     * @param $episode
     * @param $LivestreamAccount
     * @param $realStreamName
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
