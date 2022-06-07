<?php

namespace Modules\Social\Http\Livewire\Pages\Projects;

use App\Actions\Teams\ApplyToTeam;
use App\Actions\Teams\RemoveTeamApplication;
use App\Models\Team;
use App\Models\TeamApplication;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Show extends Component
{
    public $team;

    public $pageView = 'overview';

    public $additionalInfo = [
        'likes',
        'comments',
        'members'
    ];
  
    public function getOwnerProperty()
    {
        return $this->team->owner;
    }

    public function getRecentPostsProperty()
    {
        return $this->team->posts()->take(2)->get();
    }

    /**
     * Apply to a team.
     *
     * @return void
     */
    public function applyToTeam()
    {
        app(ApplyToTeam::class)->apply(
            $this->team,
            Auth::id(),
            'editor'
        );

        $this->emit('applied');
    }

    /**
     * Remove application to a team.
     *
     * @return void
     */
    public function removeApplication()
    {
        app(RemoveTeamApplication::class)
            ->remove($this->team, Auth()->id());

        $this->emit('application_removed');

        $this->team = $this->team->fresh();
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
