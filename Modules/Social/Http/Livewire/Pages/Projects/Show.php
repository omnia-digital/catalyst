<?php

namespace Modules\Social\Http\Livewire\Pages\Projects;

use App\Actions\Teams\ApplyToTeam;
use App\Models\Team;
use App\Models\TeamApplication;
use Illuminate\Support\Facades\Auth;
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

    /**
     * Apply to a team.
     *
     * @return void
     */
    public function applyToTeam()
    {
        app(ApplyToTeam::class)->apply(
            $this->project,
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
        $application = $this->project->teamApplications()->where('user_id', Auth::id())->first();

        if (! is_null($application)) {
            $application->delete();
        }

        $this->emit('application_removed');

        $this->project = $this->project->fresh();
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
