<?php

namespace Modules\Social\Http\Livewire\Pages\Teams\Admin;

use App\Models\Team;
use App\Traits\Team\WithTeamManagement;
use Livewire\Component;

class ManageTeamMembers extends Component
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
        return view('social::livewire.pages.teams.admin.manage-team-members');
    }
}
