<?php

namespace Modules\Social\Http\Livewire\Pages\Projects;

use App\Models\Team;
use App\Traits\WithTeamManagement;
use Livewire\Component;

class Members extends Component
{
    use WithTeamManagement;

    public $team;

    protected $listeners = [
        'member_added' => '$refresh',
    ];

    public function mount(Team $team)
    {
        $this->team = $team;
    }

    public function render()
    {
        return view('social::livewire.pages.projects.members');
    }
}
