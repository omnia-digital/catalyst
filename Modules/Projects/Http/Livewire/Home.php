<?php

namespace Modules\Projects\Http\Livewire;

use Livewire\Component;
use Modules\Projects\Models\Project;

class Home extends Component
{
    public $projects = [];
//    public ?int $selectedItem = null;

    public function mount()
    {
        $this->projects = Project::all();
//        $this->selectedItem = $this->projects->first();
    }

    public function render()
    {
        return view('projects::livewire.home');
    }
}
