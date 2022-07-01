<?php

namespace Modules\Social\Http\Livewire\Components;

use App\Models\Team;
use App\Models\User;
use Asantibanez\LivewireCalendar\LivewireCalendar;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class TeamCalendar extends LivewireCalendar
{
    public $selectedID;

    protected $listeners = ['select_event' => 'goToMonth'];

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

    public function goToMonth($eventID)
    {
        $this->selectedID = $eventID;
        $date = Team::find($eventID)->start_date;

        $this->startsAt = $date->startOfMonth()->startOfDay();
        $this->endsAt = $this->startsAt->clone()->endOfMonth()->startOfDay();

        $this->calculateGridStartsEnds();
    }

    public function getUserProperty()
    {
        return User::find(Auth::id());
    }
}
