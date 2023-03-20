<?php

namespace Modules\Jobs\Events;

use Modules\Jobs\Models\JobPosition;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class JobPositionWasCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var JobPosition
     */
    public JobPosition $job;

    /**
     * Create a new event instance.
     *
     * @param JobPosition $job
     */
    public function __construct(JobPosition $job)
    {
        $this->job = $job;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
