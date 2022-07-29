<?php

namespace Modules\Social\Http\Livewire\Pages\Teams;

use App\Models\Team;
use App\Models\User;
use App\Traits\Team\WithTeamManagement;
use Livewire\Component;

class Members extends Component
{
    use WithTeamManagement;

    public $team;

    public $awardsToAdd = [];

    protected $listeners = [
        'member_added' => '$refresh',
        'modal-closed' => 'resetAwardsSelection'
    ];

    public function mount(Team $team)
    {
        $this->team = $team;
    }

    public function resetAwardsSelection()
    {
        $this->reset('awardsToAdd');
    }

    public function addAward(User $member)
    {
        $member->awards()->attach($this->awardsToAdd);
        
        $this->dispatchBrowserEvent('notify', ['message' => 'Awards Added', 'type' => 'success']);
        $this->dispatchBrowserEvent('add-awards-modal-' . $member->id,  ['type' => 'close']);
    }

    public function render()
    {
        return view('social::livewire.pages.teams.members');
    }
}
