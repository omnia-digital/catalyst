<?php

namespace Modules\Jobs\Http\Livewire\Jobs;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MyJobs extends Component
{
    public function render()
    {
        $jobs = Auth::user()->currentTeam
            ->jobs()
            ->latest()
            ->get();

        return view('livewire.jobs.my-jobs', [
            'jobs' => $jobs
        ]);
    }
}
