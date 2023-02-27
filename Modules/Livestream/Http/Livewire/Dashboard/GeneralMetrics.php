<?php

namespace App\Http\Livewire\Dashboard;

use App\Metrics\EpisodeWithMostAttachmentDownloads;
use App\Metrics\MostViewedSeries;
use App\Metrics\TimeFilters\TimeFilterRegistry;
use App\Metrics\TotalAttachmentDownloads;
use App\Metrics\TotalEpisodeViews;
use App\Support\Livewire\WithTimeFilter;
use Livewire\Component;

class GeneralMetrics extends Component
{
    use WithTimeFilter;

    public function getTimeFiltersProperty()
    {
        return collect(app(TimeFilterRegistry::class)->options());
    }

    public function render()
    {
        return view('dashboard.general-metrics', [
            'totalAttachmentDownloads' => TotalAttachmentDownloads::make($this->selectedTime),
            'totalEpisodeViews' => TotalEpisodeViews::make($this->selectedTime),
            'episodeWithMostAttachmentDownloads' => EpisodeWithMostAttachmentDownloads::make($this->selectedTime),
            'mostCombinedEpisodeViews' => MostViewedSeries::make($this->selectedTime),
        ]);
    }
}
