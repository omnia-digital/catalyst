<?php

namespace Modules\Social\Http\Livewire\Partials;

use Livewire\Component;

class ActivityListItem extends Component
{
    public $activity;

    public function mount($activity)
    {
        $this->activity = $activity;
    }
    public function render()
    {
        return view('social::livewire.partials.activity-list-item');
    }
}
