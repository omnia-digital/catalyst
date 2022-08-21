<?php

namespace Modules\Social\Http\Livewire\Components;

use App\Models\Team;
use App\Models\User;
use Asantibanez\LivewireCalendar\LivewireCalendar;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Modules\Social\Support\Livewire\InteractsWithCalendarTeams;

class TeamCalendar extends LivewireCalendar
{
    use InteractsWithCalendarTeams;

    /**
     * @var string[]
     *
     * @psalm-var array{select_event: 'goToMonth'}
     */
    protected $listeners = ['select_event' => 'goToMonth'];

    /**
     * @return void
     */
    public function onEventClick($eventId)
    {
        $this->emitTo('social::components.team-calendar-list', 'teamSelected', $eventId);
    }
}
