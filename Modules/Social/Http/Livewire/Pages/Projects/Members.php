<?php

namespace Modules\Social\Http\Livewire\Pages\Projects;

use App\Models\Team;
use App\Actions\Teams\ApplyToTeam;
use App\Models\TeamApplication;
use Laravel\Jetstream\Contracts\AddsTeamMembers;
use Livewire\Component;

class Members extends Component
{
    public $team;

    public function mount(Team $team)
    {
        $this->team = $team;
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
        app(RemoveTeamApplication::class)
            ->remove($this->project, Auth()->id());

        $this->emit('application_removed');

        $this->project = $this->project->fresh();
    }

    /**
     * Add a new team member to a team.
     *
     * @param  string  $email
     * @return void
     */
    public function addTeamMember($email)
    {
        $this->resetErrorBag();

        app(AddsTeamMembers::class)->add(
            $this->user,
            $this->team,
            $email,
            'editor'
        );

        $this->team = $this->team->fresh();

        $this->emit('saved');
    }

    /**
     * Deny a pending team member's application.
     *
     * @param  int  $applicationId
     * @return void
     */
    public function denyTeamApplication($applicationId)
    {
        if (! empty($applicationId)) {
            $model = TeamApplication::class;

            $model::whereKey($applicationId)->delete();
        }

        $this->team = $this->team->fresh();
    }

    public function render()
    {
        return view('social::livewire.pages.projects.members');
    }
}
