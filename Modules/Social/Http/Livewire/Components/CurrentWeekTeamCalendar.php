<?php

namespace Modules\Social\Http\Livewire\Components;

use App\Models\User;
use Asantibanez\LivewireCalendar\LivewireCalendar;
use Auth;
use Carbon\Carbon;
use Modules\Social\Support\Livewire\InteractsWithCalendarProjects;

class CurrentWeekTeamCalendar extends LivewireCalendar
{
    use InteractsWithCalendarProjects;

    public $selectedID;

    public ?string $selectedStartDate = null;

    protected $listeners = [
        'startDateUpdated' => 'handleStartDateUpdated'
    ];

    public function handleStartDateUpdated($data)
    {
        $this->selectedStartDate = $data['start_date'];

        $this->calculateGridStartsEnds();
    }

    public function calculateGridStartsEnds()
    {
        $date = $this->selectedStartDate ? Carbon::parse($this->selectedStartDate) : now();

        $this->gridStartsAt = $date->clone()->startOfWeek($this->weekStartsAt);
        $this->gridEndsAt = $date->clone()->endOfWeek($this->weekEndsAt);
    }

    public function getUserProperty()
    {
        return User::find(Auth::id());
    }
}
