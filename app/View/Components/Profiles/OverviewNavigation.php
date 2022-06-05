<?php

namespace App\View\Components\Profiles;

use App\Models\User;
use Illuminate\View\Component;

class OverviewNavigation extends Component
{

    public $user;
    public $pageView;
    
    public $nav = [
        'show' => 'Overview',
        'media' => 'Media',
        'followers' => 'Followers'
    ];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(User $user, $pageView = 'show')
    {
        $this->user = $user;
        $this->pageView = $pageView;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.profiles.overview-navigation');
    }
}
