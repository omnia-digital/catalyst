<?php

namespace Modules\Livestream\Support\Livewire;

use Carbon\CarbonPeriod;
use Modules\Livestream\Metrics\TimeFilters\TimeFilterRegistry;

trait WithTimeFilter
{
    public string $selectedTime = '30-days';

    public function initializeWithTimeFilter()
    {
        $this->selectedTime = session()->get($this->getTimeFilterSessionKey(), $this->selectedTime);
    }

    public function selectTime(string $time)
    {
        $this->selectedTime = $time;

        session()->put($this->getTimeFilterSessionKey(), $this->selectedTime);
    }

    public function getTimeFiltersProperty()
    {
        return app(TimeFilterRegistry::class)->options();
    }

    public function getDateRangeProperty()
    {
        $timeFilter = app(TimeFilterRegistry::class)->get($this->selectedTime);

        return CarbonPeriod::create($timeFilter->from(), $timeFilter->step(), $timeFilter->to());
    }

    public function getLabelsProperty()
    {
        foreach ($this->dateRange as $date) {
            $labels[] = $date->format($this->labelFormat());
        }

        return $labels ?? [];
    }

    public function labelFormat()
    {
        return match ($this->selectedTime) {
            'today' => 'H:i',
            '7-days', '30-days', 'last-month', 'this-month' => 'D, d M',
            '6-months', 'this-year', 'all-time' => 'M Y',
            'default' => 'Y-m-d'
        };
    }

    private function getTimeFilterSessionKey(): string
    {
        return 'timeFilter' . get_class($this);
    }
}
