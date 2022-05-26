<?php

namespace App\View\Components\Teams;

use App\Models\Team;
use Illuminate\View\Component;

class OverviewNavigation extends Component
{

    public $team;
    public $pageView;
    
    public $nav = [
        'show' => 'Overview',
        'members' => 'Members',
        'followers' => 'Followers'
    ];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Team $team, $pageView = 'show')
    {
        $this->team = $team;
        $this->pageView = $pageView;
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
