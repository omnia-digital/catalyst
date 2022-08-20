<?php

namespace Modules\Social\Http\Livewire\Pages\Teams;

use App\Models\Team;
use Livewire\Component;

class Awards extends Component
{
    public $team;
        
    public function mount(Team $team): void
    {
        $this->team = $team->load('owner');
    }

    public function render(): \Illuminate\View\View
    {
        return view('social::livewire.pages.teams.awards');
    }
}
