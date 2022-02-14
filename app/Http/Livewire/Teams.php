<?php

namespace Modules\Teams\Http\Livewire;

use App\Models\Team;
use Livewire\Component;

class Teams extends Component
{
    public $teams = [];

    public function mount()
    {
        $this->teams = Team::all();
    }

    public function render()
    {
        return view('livewire.teams');
    }
}
