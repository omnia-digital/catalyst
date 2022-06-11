<?php

namespace Modules\Social\Http\Livewire\Pages\Projects;

use App\Models\Team;
use App\Traits\WithTeamManagement;
use Livewire\Component;

class Show extends Component
{
    use WithTeamManagement;

    public $team;

    public $additionalInfo = [
        'likes',
        'comments',
        'members'
    ];

    public function getRecentPostsProperty()
    {
        return $this->team->posts()->take(2)->get();
    }

    public function showPost($post) {
        return $this->redirectRoute('social.posts.show', $post['id']);
    }
    
    public function mount(Team $team)
    {
        $this->team = $team->load('owner');
    }

    public function render()
    {
        return view('social::livewire.pages.projects.show');
    }
}
