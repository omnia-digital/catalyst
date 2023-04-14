<?php

namespace Modules\Livestream\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Modules\Livestream\Models\Episode;

class EpisodeCreatedEvent
{
    use Dispatchable;

    public function __construct(
        public Episode $episode
    ) {
    }
}
