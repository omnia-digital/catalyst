<?php

namespace Modules\Social\Http\Livewire\Pages\Teams;

use App\Models\Team;
use Livewire\Component;

class Followers extends Component
{
    public $team;
        
    public function mount(Team $team)
    {
        $this->team = $team->load('owner');
    }

    public function render()
    {
        return view('social::livewire.pages.teams.followers');
    }
}
