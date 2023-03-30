<?php

namespace Modules\Livestream\Http\Livewire\Dashboard;

use Livewire\Component;
use Modules\Livestream\Metrics\EpisodeWithMostAttachmentDownloads;
use Modules\Livestream\Metrics\MostViewedSeries;
use Modules\Livestream\Metrics\TimeFilters\TimeFilterRegistry;
use Modules\Livestream\Metrics\TotalAttachmentDownloads;
use Modules\Livestream\Metrics\TotalEpisodeViews;
use Modules\Livestream\Support\Livewire\WithTimeFilter;

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
