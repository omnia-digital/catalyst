<?php

namespace Modules\Social\Http\Livewire\Pages\Projects;

use App\Models\Team;
use App\Actions\Teams\ApplyToTeam;
use App\Actions\Teams\RemoveTeamApplication;
use App\Models\TeamApplication;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\Contracts\AddsTeamMembers;
use Livewire\Component;

class Members extends Component
{
    public $team;

    protected $listeners = [
        'member_added' => '$refresh',
    ];

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

    /**
     * Add a new team member to a team.
     *
     * @param  string  $userID
     * @return void
     */
    public function addTeamMember($userID)
    {
        $this->resetErrorBag();

        $user = User::find($userID);

        app(AddsTeamMembers::class)->add(
            Auth::user(),
            $this->team,
            $user->email,
            'editor'
        );

        $this->team->teamApplications()->where('user_id', $userID)->delete();
        $this->team = $this->team->fresh();

        $this->emit('member_added');
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
