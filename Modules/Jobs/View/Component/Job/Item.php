<?php

namespace Modules\Jobs\View\Component\Job;

use Illuminate\View\Component;
use Modules\Jobs\Models\JobPosition;

class Item extends Component
{
    public JobPosition $job;

    public $attributes;

    public function __construct($job, $attributes)
    {
        $this->job = $job;
        $this->attributes = $attributes;

    }

    public function render()
    {
        return view('components.job.item');
    }
}
