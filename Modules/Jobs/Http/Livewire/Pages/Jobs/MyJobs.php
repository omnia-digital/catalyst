<?php

namespace Modules\Jobs\Http\Livewire\Pages\Jobs;

use Livewire\Component;

class MyJobs extends Component
{
    public function render()
    {
        $jobs = auth()->user()->currentTeam
            ->jobs()
            ->latest()
            ->get()
        ->sortByDesc(['is_active', 'created_at']);

        return view('jobs::livewire.pages.jobs.my-jobs', [
            'jobs' => $jobs,
        ]);
    }
}
