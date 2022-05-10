<?php

namespace Modules\Social\Http\Livewire\Pages\Projects;

use App\Models\Team;
use App\Models\User;
use Livewire\Component;

class MyProjects extends Component
{
    public $projects;

    public function render()
    {
        $this->projects = Team::factory(15)
                            ->has(User::factory(random_int(3, 9)))
                            ->make();

        return view('social::livewire.pages.projects.my-projects');
    }
}
