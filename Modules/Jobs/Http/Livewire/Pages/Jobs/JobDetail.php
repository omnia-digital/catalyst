<?php

namespace Modules\Jobs\Http\Livewire\Jobs;

use Modules\Jobs\Models\Job;
use Livewire\Component;

class JobDetail extends Component
{
    public $job;

    public function mount(Job $job)
    {
        $this->job = $job;
    }

    public function render()
    {
        return view('livewire.jobs.job-detail');
    }
}
