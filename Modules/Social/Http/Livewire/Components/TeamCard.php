<?php

namespace Modules\Social\Http\Livewire\Components;

use App\Models\Team;
use Livewire\Component;

class TeamCard extends Component
{
    public $team;

    public function mount(Team $team)
    {
        $this->team = $team;
    }

    public function showTeam()
    {
        return redirect($this->team->profile());
    }
    
    public function render()
    {
        return view('social::livewire.components.team-card');
    }
}
