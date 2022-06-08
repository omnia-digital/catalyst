<?php

namespace Modules\Social\Http\Livewire\Pages\Projects;

use App\Models\Team;
use Livewire\Component;

class Followers extends Component
{
    public $team;

    public $pageView = 'followers';

        
    public function mount(Team $team)
    {
        $this->team = $team->load('owner');
    }

    public function getOwnerProperty()
    {
        return $this->team->owner;
    }

    public function render()
    {
        return view('social::livewire.pages.projects.followers');
    }
}
