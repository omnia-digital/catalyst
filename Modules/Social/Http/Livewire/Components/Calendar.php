<?php

namespace Modules\Social\Http\Livewire\Components;

use App\Models\Team;
use App\Models\User;
use Modules\Social\Support\Livewire\InteractsWithCalendarTeams;
use Omnia\LivewireCalendar\LivewireCalendar;

class Calendar extends LivewireCalendar
{
    use InteractsWithCalendarTeams;

    public $id = 'calendar';
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
        $this->dispatch('teamSelected', eventId: $eventId)->to('social::components.teams.team-calendar-list');
    }

    public function getUserProperty()
    {
        return User::find(auth()->id());
    }
}
