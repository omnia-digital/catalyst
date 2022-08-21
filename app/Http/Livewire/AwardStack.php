<?php

namespace App\Http\Livewire;

use App\Models\Team;
use Livewire\Component;
use App\Models\User;

class AwardStack extends Component
{
    public $awardsToAdd = [];

    public $user;

    public $awards;

    public Team|null $team = null;

    protected $listeners = [
        'modal-closed' => 'resetAwardsSelection'
    ];

    public function mount(User $user, Team $team = null)
    {
        $this->user = $user;
        $this->awards = $user->awards;
        $this->team = $team;
    }

    public function resetAwardsSelection()
    {
        $this->reset('awardsToAdd');
    }

    public function addAward(User $user)
    {
        $user->awards()->attach($this->awardsToAdd);
        
        $this->dispatchBrowserEvent('notify', ['message' => 'Awards Added', 'type' => 'success']);
        $this->dispatchBrowserEvent('add-awards-modal-' . $user->id,  ['type' => 'close']);
    }

    public function render()
    {
        return view('livewire.award-stack');
    }
}
