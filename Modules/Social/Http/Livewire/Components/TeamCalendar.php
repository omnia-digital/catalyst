<?php

namespace Modules\Social\Http\Livewire\Components;

use App\Models\Team;
use App\Models\User;
use Asantibanez\LivewireCalendar\LivewireCalendar;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Modules\Social\Support\Livewire\InteractsWithCalendarProjects;

class TeamCalendar extends LivewireCalendar
{
    use InteractsWithCalendarProjects;

    public $selectedID;

    protected $listeners = ['select_event' => 'goToMonth'];

    public function goToMonth($eventID)
    {
        $this->selectedID = $eventID;
        $date = Team::find($eventID)->start_date;

        $this->startsAt = $date->startOfMonth()->startOfDay();
        $this->endsAt = $this->startsAt->clone()->endOfMonth()->startOfDay();

        $this->calculateGridStartsEnds();
    }

    public function onEventClick($eventId)
    {
        $this->emitTo('social::components.team-calendar-list', 'teamSelected', $eventId);
    }

    public function getUserProperty()
    {
        return User::find(Auth::id());
    }
}
