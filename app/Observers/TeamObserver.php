<?php

namespace App\Observers;

use App\Models\Team;
use function activity;

class TeamObserver
{
    public function created(Team $team): void
    {
        activity()->by($team->owner)->on($team)->log(\Trans::get("Team $team->name created"));
    }

    public function updated(Team $team): void
    {
        activity()->by($team->owner)->on($team)->log(\Trans::get("Team $team->name updated"));
    }

    public function deleted(Team $team): void
    {
        activity()->by($team->owner)->on($team)->log(\Trans::get("Team $team->name deleted"));
    }

    public function restored(Team $team): void
    {
        activity()->by($team->owner)->on($team)->log(\Trans::get("Team $team->name restored"));
    }

    public function forceDeleted(Team $team): void
    {
        activity()->by($team->owner)->on($team)->log(\Trans::get("Team $team->name force deleted"));
    }
}
