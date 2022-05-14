<?php

namespace Modules\Social\Http\Livewire\Components;

use App\Models\Team;
use Livewire\Component;

class ProjectCard extends Component
{
    public $project;

    public function mount(Team $project)
    {
        $this->project = $project;
    }
    
    public function render()
    {
        return view('social::livewire.components.project-card');
    }
}
