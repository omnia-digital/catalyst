<?php

namespace App\Http\Livewire\Pages\Teams;

use App\Models\Team;
use Livewire\Component;

class Show extends Component
{
    public $project;

    public function mount(Team $team)
    {
        $this->project = $team;
    }

    public function render()
    {
        return view('livewire.pages.teams.show');
    }
}
