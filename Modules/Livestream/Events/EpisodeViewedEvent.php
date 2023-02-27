<?php

namespace App\Events;

use App\Models\Episode;
use Illuminate\Foundation\Events\Dispatchable;

class EpisodeViewedEvent
{
    use Dispatchable;

    public function __construct(
        public Episode $episode,
    ) {

    }
}
