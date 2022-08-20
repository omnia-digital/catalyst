<?php

namespace Modules\Social\Http\Livewire\Components;

use App\Models\User;
use Asantibanez\LivewireCalendar\LivewireCalendar;
use Auth;
use Carbon\Carbon;
use Modules\Social\Support\Livewire\InteractsWithCalendarTeams;

class CurrentWeekTeamCalendar extends LivewireCalendar
{
    use InteractsWithCalendarTeams;

    public $selectedID;

    public ?string $selectedStartDate = null;

    protected $listeners = [
        'startDateUpdated' => 'handleStartDateUpdated'
    ];

    public function handleStartDateUpdated($data): void
    {
        $this->selectedStartDate = $data['start_date'];

        $this->calculateGridStartsEnds();
    }

    /**
     * @return void
     */
    public function calculateGridStartsEnds()
    {
        $date = $this->selectedStartDate ? Carbon::parse($this->selectedStartDate) : now();

        $this->gridStartsAt = $date->clone()->startOfWeek($this->weekStartsAt);
        $this->gridEndsAt = $date->clone()->endOfWeek($this->weekEndsAt);
    }

    public function getUserProperty(): User|null
    {
        return User::find(Auth::id());
    }
}
