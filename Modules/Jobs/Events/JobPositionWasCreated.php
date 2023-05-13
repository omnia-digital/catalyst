<?php

namespace Modules\Jobs\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Jobs\Models\JobPosition;

class JobPositionWasCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public JobPosition $job;

    /**
     * Create a new event instance.
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
