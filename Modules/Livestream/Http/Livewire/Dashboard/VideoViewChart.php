<?php namespace App\Http\Livewire\Dashboard;

use App\Metrics\StorageDurationChart;
use App\Metrics\TimeFilters\TimeFilterRegistry;
use App\Metrics\TotalVideoViewsByLivestreamAccountChart;
use App\Services\Mux\DataTransferObjects\VideoView;
use App\Support\Livewire\WithTimeFilter;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use Livewire\Component;

/**
 * @property CarbonPeriod $dateRange
 * @property array $labels
 * @property Collection $data
 */
class VideoViewChart extends Component
{
    use WithTimeFilter;

    public function toChart(Collection $items): array
    {
        /** @var Carbon $date */
        foreach ($this->dateRange as $date) {
            $chartData[] = $items->filter(function ($item) use ($date) {
                return Carbon::parse($item->viewStart)->format($this->labelFormat()) === $date->format($this->labelFormat());
            })->count();
        }

        return $chartData ?? [];
    }

    public function total(Collection $items)
    {
        return $items->count();
    }

    public function getDataProperty()
    {
        return TotalVideoViewsByLivestreamAccountChart::make($this->selectedTime);
    }

    public function getTimeFiltersProperty()
    {
        return collect(app(TimeFilterRegistry::class)->options())
            ->only('today', '7-days', '30-days');
    }

    public function render()
    {
        return view('dashboard.video-view-chart', [
            'labels'          => $this->labels,
            'videoViews'      => $this->toChart($this->data),
            'totalVideoViews' => (float)$this->total($this->data),
        ]);
    }
}
