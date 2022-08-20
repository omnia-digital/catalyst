<?php

namespace Modules\Social\Http\Livewire\Components;

use App\Models\Team;
use Livewire\Component;

class TeamCard extends Component
{
    public $team;

    public function mount(Team $team): void
    {
        $this->team = $team;
    }

    public function showTeam(): \Illuminate\Http\RedirectResponse
    {
        return redirect($this->team->profile());
    }
    
    public function render(): \Illuminate\View\View
    {
        return view('social::livewire.components.team-card');
    }
}
