<?php

namespace Modules\Livestream\Events;

use Modules\Livestream\Models\Episode;
use Illuminate\Foundation\Events\Dispatchable;

class EpisodeViewedEvent
{
    use Dispatchable;

    public function __construct(
        public Episode $episode,
    ) {

    }
}
