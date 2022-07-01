<?php

namespace Modules\Social\Http\Livewire\Components;

use App\Models\Team;
use App\Models\User;
use Asantibanez\LivewireCalendar\LivewireCalendar;
use Auth;
use Illuminate\Support\Collection;

class TeamCalendar extends LivewireCalendar
{

    public function events() : Collection
    {
        return Team::query()
            ->whereDate('start_date', '>=', $this->gridStartsAt)
            ->whereDate('start_date', '<=', $this->gridEndsAt)
            ->get()
            ->map(function (Team $team) {
                return [
                    'id' => $team->id,
                    'title' => $team->name,
                    'description' => $team->summary,
                    'date' => $team->start_date,
                    'count' => $team->allUsers()->count(),
                    'location' => $team->location
                ];
            });
    }

    public function getUserProperty()
    {
        return User::find(Auth::id());
    }
}
