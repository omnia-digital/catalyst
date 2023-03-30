<?php

namespace Modules\Livestream\Listeners;

use Modules\Livestream\Events\EpisodeCreatedEvent;
use Modules\Livestream\Services\Plausible\Plausible;

class TrackEpisodeCreatedGoalListener
{
    public function handle(EpisodeCreatedEvent $event)
    {
        app(Plausible::class)->dispatchCustomEvent(config('plausible.events.episode-created'), [
            'team' => $event->episode->livestreamAccount->team_id,
        ]);
    }
}
