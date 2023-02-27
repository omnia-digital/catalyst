<?php

namespace App\Listeners;

use App\Events\EpisodeCreatedEvent;
use App\Services\Plausible\Plausible;

class TrackEpisodeCreatedGoalListener
{
    public function handle(EpisodeCreatedEvent $event)
    {
        app(Plausible::class)->dispatchCustomEvent(config('plausible.events.episode-created'), [
            'team' => $event->episode->livestreamAccount->team_id
        ]);
    }
}
