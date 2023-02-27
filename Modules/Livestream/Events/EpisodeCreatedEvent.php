<?php

namespace Modules\Livestream\Events;

use Modules\Livestream\Models\Episode;
use Illuminate\Foundation\Events\Dispatchable;

class EpisodeCreatedEvent
{
    use Dispatchable;

    public function __construct(
        public Episode $episode
    ) {}
}
