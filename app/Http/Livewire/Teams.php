<?php

namespace App\Http\Livewire;

use App\Models\Team;
use Livewire\Component;

class Teams extends Component
{
    public $projects = [];

    public function mount()
    {
        $this->projects = Team::all();
    }

    public function render()
    {
        return view('livewire.teams');
    }
}
