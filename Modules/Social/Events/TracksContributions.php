<?php

namespace Modules\Social\Events;

use Illuminate\Queue\SerializesModels;

abstract class TracksContributions
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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

    abstract public function trackContribution();
}
