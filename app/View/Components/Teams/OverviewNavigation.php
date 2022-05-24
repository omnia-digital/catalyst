<?php

namespace App\View\Components\Teams;

use App\Models\Team;
use Illuminate\View\Component;

class OverviewNavigation extends Component
{

    public $team;
    public $pageView = 'overview';
    
    public $nav = [
        'overview' => 'Overview',
        'members' => 'Members',
        'followers' => 'Followers'
    ];

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
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.teams.overview-navigation');
    }
}
