<?php

namespace Modules\Jobs\Http\Livewire\Pages;

use App\Support\Platform\Platform;
use Livewire\Component;
use Modules\Jobs\Models\JobPosition;

class Home extends Component
{
    public function render()
    {
        $featuredJobs = \Modules\Jobs\Models\JobPosition::with(['company', 'skills', 'addons'])
                                                        ->featured(Platform::getJobSetting('featured_days', 30))
                                                        ->active()
                                                        ->latest()
                                                        ->when(Platform::getJobSetting('featured_jobs_limit'), fn($query, $limit) => $query->take($limit))
                                                        ->get();

        $jobs = JobPosition::with(['company', 'skills', 'addons'])
                           ->whereNotIn('id', $featuredJobs->pluck('id'))
                           ->active()
                           ->latest()
                           ->get();

        return view('jobs::livewire.pages.home', [
            'jobs'         => $jobs,
            'featuredJobs' => $featuredJobs
        ]);
    }
}
