<?php

namespace Modules\Social\Http\Livewire\Pages\Projects\Partials;

use App\Models\Team;
use Livewire\Component;

class Header extends Component
{
    public Team $team;

    public function mount(Team $team)
    {
        $this->team = $team;
    }
    
    public function render()
    {
        return view('social::livewire.pages.projects.partials.header');
    }
}
