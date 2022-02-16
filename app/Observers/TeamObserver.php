<?php

namespace App\Observers;

use Modules\Teams\Models\Team;
use function activity;

class TeamObserver
{
    /**
     * Handle the Team "created" event.
     *
     * @param  \App\Models\Team  $team
     * @return void
     */
    public function created(Team $team)
    {
        activity()->by($team->owner)->on($team)->log("Team $team->name created");
    }

    /**
     * Handle the Team "updated" event.
     *
     * @param  \App\Models\Team  $team
     * @return void
     */
    public function updated(Team $team)
    {
        activity()->by($team->owner)->on($team)->log("Team $team->name updated");
    }

    /**
     * Handle the Team "deleted" event.
     *
     * @param  \App\Models\Team  $team
     * @return void
     */
    public function deleted(Team $team)
    {
        activity()->by($team->owner)->on($team)->log("Team $team->name deleted");
    }

    /**
     * Handle the Team "restored" event.
     *
     * @param  \App\Models\Team  $team
     * @return void
     */
    public function restored(Team $team)
    {
        activity()->by($team->owner)->on($team)->log("Team $team->name restored");
    }

    /**
     * Handle the Team "force deleted" event.
     *
     * @param  \App\Models\Team  $team
     * @return void
     */
    public function forceDeleted(Team $team)
    {
        activity()->by($team->owner)->on($team)->log("Team $team->name force deleted");
    }
}
