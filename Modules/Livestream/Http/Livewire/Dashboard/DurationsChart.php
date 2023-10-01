<?php

namespace Modules\Livestream\Http\Livewire\Dashboard;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Livewire\Component;
use Modules\Livestream\Metrics\StorageDurationChart;
use Modules\Livestream\Support\Livewire\WithTimeFilter;

/**
 * @property CarbonPeriod $dateRange
 * @property array $labels
 */
class DurationsChart extends Component
{
    use WithTimeFilter;

    public function getStorageDurationsProperty()
    {
        return StorageDurationChart::make($this->selectedTime);
    }

    public function render()
    {
        return view('dashboard.durations-chart', [
            'labels' => $this->labels,
            'storageDurations' => $this->toChart($this->storageDurations),
            'totalStorageDurations' => (float)$this->total($this->storageDurations),
            'totalPreviousStorageDurations' => (float)$this->total(StorageDurationChart::previous()->make($this->selectedTime)),
        ]);
    }

    public function toChart($items): array
    {
        /** @var Carbon $date */
        foreach ($this->dateRange as $date) {
            foreach ($items as $item) {
                // Make sure both dates have same formatting.
                $chartData[] = Carbon::parse($item['date'])->format($this->labelFormat()) === $date->format($this->labelFormat())
                    ? $item['value']
                    : 0;
            }
        }

        return $chartData ?? [];
    }

    public function total($items)
    {
        return $items->sum(fn($item) => $item['value']);
    }
}
