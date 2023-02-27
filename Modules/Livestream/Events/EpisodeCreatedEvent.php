<?php

namespace App\Events;

use App\Models\Episode;
use Illuminate\Foundation\Events\Dispatchable;

class EpisodeCreatedEvent
{
    use Dispatchable;

    public function __construct(
        public Episode $episode
    ) {}
}
