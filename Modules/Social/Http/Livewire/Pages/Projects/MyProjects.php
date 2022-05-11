<?php

namespace Modules\Social\Http\Livewire\Pages\Projects;

use App\Models\Team;
use Livewire\Component;

class MyProjects extends Component
{
    public $projects;

    public function render()
    {
        $this->projects = Team::factory(15)->make();
        return view('social::livewire.pages.projects.my-projects', ['projects' => $this->projects]);
    }
}
