<?php

namespace App\Events\Episode;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Http\Requests\Notifications\StreamEndNotificationRequest;

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
