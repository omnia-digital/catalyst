<?php

namespace Modules\Social\Http\Livewire\Pages\Teams;

use App\Models\Team;
use App\Traits\Team\WithTeamManagement;
use Livewire\Component;

class Members extends Component
{
    use WithTeamManagement;

    public $team;

    protected $listeners = [
        'member_added' => '$refresh',
    ];

    public function mount(Team $team): void
    {
        $this->team = $team;
    }

    public function render(): \Illuminate\View\View
    {
        return view('social::livewire.pages.teams.members');
    }
}
