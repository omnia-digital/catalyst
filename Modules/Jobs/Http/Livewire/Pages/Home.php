<?php

namespace Modules\Jobs\Http\Livewire\Pages;

use Livewire\Component;
use Modules\Jobs\Models\Job;

class Home extends Component
{
    public function render(): \Illuminate\View\View
    {
        $featuredJobs = Job::with(['company', 'tags', 'addons'])
                           ->latest()
                           ->get();

        $jobs = Job::with(['company', 'tags', 'addons'])
                   ->whereNotIn('id', $featuredJobs->pluck('id'))
                   ->latest()
                   ->get();

        return view('jobs::livewire.pages.home',[
                    'jobs'         => $jobs,
            'featuredJobs' => $featuredJobs
        ]);
    }
}
