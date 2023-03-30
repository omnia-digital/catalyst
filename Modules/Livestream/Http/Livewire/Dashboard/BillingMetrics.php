<?php

namespace Modules\Livestream\Http\Livewire\Dashboard;

use Livewire\Component;
use Modules\Livestream\Metrics\BillableStorageDuration;
use Modules\Livestream\Metrics\CurrentStorageCost;
use Modules\Livestream\Metrics\TotalExpiredEpisodeCount;
use Modules\Livestream\Metrics\TotalStorageDuration;

class BillingMetrics extends Component
{
    public function render()
    {
        return view('dashboard.billing-metrics', [
            'totalStorageDuration' => TotalStorageDuration::make('this-month'),
            'billableStorageDuration' => BillableStorageDuration::make('this-month'),
            'currentStorageCost' => CurrentStorageCost::make('this-month'),
            'totalExpiredEpisodeCount' => TotalExpiredEpisodeCount::make('this-month'),
        ]);
    }
}
