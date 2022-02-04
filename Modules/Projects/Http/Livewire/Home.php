<?php

namespace Modules\Projects\Http\Livewire;

use Livewire\Component;

class Home extends Component
{

    public $projects = [];

    public function render()
    {
        return view('projects::livewire.home');
    }
}
