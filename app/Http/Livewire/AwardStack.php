<?php

namespace App\Http\Livewire;

use App\Models\Team;
use Livewire\Component;
use App\Models\User;

class AwardStack extends Component
{
    public $user;

    public $awards;

    public Team|null $team = null;

    public function mount(User $user, Team $team = null)
    {
        $this->user = $user;
        $this->awards = $user->awards()->take(3)->get();
        $this->team = $team;
    }

    public function render()
    {
        return view('livewire.award-stack');
    }
}
