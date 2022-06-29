<?php

namespace Modules\Social\Http\Livewire\Partials;

use App\Actions\Teams\RemoveTeamApplication;
use App\Models\Team;
use App\Models\TeamApplication;
use App\Models\TeamInvitation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\Contracts\AddsTeamMembers;
use Livewire\Component;

class Applications extends Component
{
    public $invitations;
    public $applications;

    public function mount()
    {
        $this->invitations = $this->user->teamInvitations;

        $this->applications = $this->user->teamApplications;
    }

    /**
     * Accept Invitation and add the current user to a team.
     *
     * @param  string  $invitationID
     * @return void
     */
    public function addTeamMember($invitationID)
    {
        $this->resetErrorBag();

        $invitation = TeamInvitation::find($invitationID);

        app(AddsTeamMembers::class)->add(
            $invitation->team->owner,
            $invitation->team,
            $this->user->email,
            'editor'
        );

        $invitation->delete();

        $this->invitations = $this->invitations->fresh();
        $this->emit('team_action', "Invitation accepted");
    }

    /**
     * Cancel a pending team member invitation.
     *
     * @param  int  $invitationID
     * @return void
     */
    public function cancelTeamInvitation($invitationID)
    {
        if (! empty($invitationID)) {
            TeamInvitation::find($invitationID)->delete();
        }

        $this->invitations = $this->invitations->fresh();
        $this->emit('team_action', "Invitation declined");
    }

    /**
     * Remove application to a team.
     *
     * @return void
     */
    public function removeApplication($applicationID)
    {
        if (! empty($applicationID)) {
            TeamApplication::find($applicationID)->delete();
        }

        $this->applications = $this->applications->fresh();
        $this->emit('team_action', 'Application removed');
    }

    public function invitationsCount()
    {
        return $this->invitations->count();
    }

    public function applicationsCount()
    {
        return $this->applications->count();
    }

    public function testClick()
    {
        $this->emit('team_action', "Invitation declined");
    }
    
    public function getUserProperty()
    {
        return User::find(Auth::id());
    }

    public function render()
    {
        return view('social::livewire.partials.applications');
    }
}
