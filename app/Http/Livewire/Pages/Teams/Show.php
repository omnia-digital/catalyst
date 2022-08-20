<?php

namespace App\Http\Livewire\Pages\Teams;

use App\Models\Team;
use Livewire\Component;

class Show extends Component
{
    public $team;

    public function mount(Team $team): void
    {
        $this->team = $team;

        visits($team)->increment();
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.pages.teams.show');
    }
}
