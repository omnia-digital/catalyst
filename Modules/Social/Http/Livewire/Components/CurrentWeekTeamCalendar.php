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

    public ?string $selectedStartDate = null;

    /**
     * @var string[]
     *
     * @psalm-var array{startDateUpdated: 'handleStartDateUpdated'}
     */
    protected array $listeners = [
        'startDateUpdated' => 'handleStartDateUpdated'
    ];

    /**
     * @return void
     */
    public function calculateGridStartsEnds()
    {
        $date = $this->selectedStartDate ? Carbon::parse($this->selectedStartDate) : now();

        $this->gridStartsAt = $date->clone()->startOfWeek($this->weekStartsAt);
        $this->gridEndsAt = $date->clone()->endOfWeek($this->weekEndsAt);
    }
}
