<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
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
     * @return View|Closure|string
     */
    public function render()
    {
        return view('components.user-tile');
    }
}
