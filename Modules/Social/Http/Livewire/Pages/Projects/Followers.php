<?php

namespace Modules\Social\Http\Livewire\Pages\Projects;

use Livewire\Component;

class Followers extends Component
{
    public $project;

    public $pageView = 'followers';

    public function getOwnerProperty()
    {
        return $this->project->owner;
    }

    public function render()
    {
        return view('social::livewire.pages.projects.followers');
    }
}
