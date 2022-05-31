<?php

namespace Modules\Social\Http\Livewire\Pages\Projects;

use App\Models\Team;
use Livewire\Component;

class Show extends Component
{
    public $project;

    public $pageView = 'overview';

    public $additionalInfo = [
        'likes',
        /* 'views', */
        'comments',
        /* 'volunteers', */
        'members'
    ];
  
    public function getOwnerProperty()
    {
        return $this->project->owner;
    }

    public function getRecentPostsProperty()
    {
        return $this->project->posts()->take(2)->get();
    }
    public function mount(Team $team)
    {
        $this->project = $team->load('owner');
    }

    public function render()
    {
        return view('social::livewire.pages.projects.show');
    }
}
