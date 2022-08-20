<?php

namespace App\View\Components\Profiles;

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class OverviewNavigation extends Component
{

    public User $user;
    public string $pageView;
    
    /**
     * @var string[]
     *
     * @psalm-var array{show: 'Overview', media: 'Media', followers: 'Followers'}
     */
    public array $nav = [
        'show' => 'Overview',
        'media' => 'Media',
        'followers' => 'Followers'
    ];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->pageView = array_slice(explode('.', Route::currentRouteName()), -1)[0];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('components.profiles.overview-navigation');
    }
}
