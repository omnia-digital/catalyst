<?php

namespace App\View\Components\Teams\Partials;

use App\Models\Team;
use Illuminate\View\Component;

class Header extends Component
{
    public Team $team;
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Team $team)
    {
        $this->team = $team;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('components.teams.partials.header');
    }
}
