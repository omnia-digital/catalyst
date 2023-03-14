<?php

namespace Modules\Jobs\View\Component\Job;

use Illuminate\View\Component;
use Modules\Jobs\Models\JobPosition;

class Item extends Component
{
    public JobPosition $job;

    public function __construct($job)
    {
        $this->job = $job;
    }

    public function render()
    {
        return view('jobs::components.job.item');
    }
}
