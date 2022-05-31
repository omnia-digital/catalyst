<?php

namespace Modules\Social\Http\Livewire\Components;

use App\Models\Team;
use Livewire\Component;

class ProjectNavigation extends Component
{
    public $project;
    public $pageView = 'overview';
    
    public $nav = [
        'overview' => 'Overview',
        'members' => 'Members',
        'followers' => 'Followers'
    ];


    public function mount(Team $project)
    {
        $this->project = $project;
    }

    public function render()
    {
        return view('social::livewire.components.project-navigation');
    }
}
