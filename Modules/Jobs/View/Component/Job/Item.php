<?php

namespace Modules\Jobs\View\Component\Job;

use Illuminate\View\Component;
use Modules\Jobs\Models\Job;

class Item extends Component
{


    public $attributes;

    /**
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('components.job.item');
    }
}
