<?php

namespace Modules\Social\Http\Livewire;

use Livewire\Component;

class UserTile extends Component
{
    public $user;

    public function mount($user)
    {
        $this->user -> $user;
    }
    
    public function render()
    {
        return view('social::livewire.user-tile');
    }
}
