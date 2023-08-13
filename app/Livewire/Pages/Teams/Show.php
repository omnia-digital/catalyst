<?php

namespace App\Livewire\Pages\Teams;

use App\Models\Team;
use Livewire\Component;

class Show extends Component
{
    public $team;

    public function mount(Team $team)
    {
        $this->team = $team;

        visits($team)->increment();
    }

    public function render()
    {
        return view('livewire.pages.teams.show');
    }
}
