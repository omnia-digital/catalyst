<?php

namespace App\View\Components;

use Illuminate\View\Component;

class UserTile extends Component
{
    public $user;
    public $team;
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($user, $team = null)
    {
        $this->user = $user;
        $this->team = $team;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.user-tile');
    }
}
