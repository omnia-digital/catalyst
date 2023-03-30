<?php

namespace Modules\Jobs\Http\Livewire\Pages\Jobs;

use Livewire\Component;
use Modules\Jobs\Models\JobPosition;

class JobDetail extends Component
{
    public $job;

    public function mount(JobPosition $job)
    {
        $this->job = $job;
    }

    public function render()
    {
        return view('jobs::livewire.pages.jobs.job-detail');
    }
}
