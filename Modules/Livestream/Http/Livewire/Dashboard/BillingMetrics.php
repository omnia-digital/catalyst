<?php

namespace App\Http\Livewire\Dashboard;

use App\Metrics\CurrentStorageCost;
use App\Metrics\BillableStorageDuration;
use App\Metrics\TotalExpiredEpisodeCount;
use App\Metrics\TotalStorageDuration;
use Livewire\Component;

class BillingMetrics extends Component
{
    public function render()
    {
        return view('dashboard.billing-metrics', [
            'totalStorageDuration' => TotalStorageDuration::make('this-month'),
            'billableStorageDuration' => BillableStorageDuration::make('this-month'),
            'currentStorageCost'   => CurrentStorageCost::make('this-month'),
            'totalExpiredEpisodeCount'   => TotalExpiredEpisodeCount::make('this-month'),
        ]);
    }
}
