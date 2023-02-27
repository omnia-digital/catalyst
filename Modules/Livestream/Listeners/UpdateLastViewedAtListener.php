<?php

namespace App\Listeners;

use App\Events\EpisodeViewedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateLastViewedAtListener implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(EpisodeViewedEvent $event)
    {
        $event->episode->update([
            'last_viewed_at' => now()
        ]);
    }
}
