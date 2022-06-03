<?php

namespace Modules\Social\Http\Livewire\Partials;

use App\Models\Team;
use App\Models\TeamInvitation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\Contracts\AddsTeamMembers;
use Livewire\Component;

class Applications extends Component
{
    public $invitations;
    public $invitationsCount = 0;
    public $applications;
    public $applicationsCount = 0;

    protected $listeners = [
        'project_action' => 'projectAction'
    ];

    public function projectAction()
    {
        $this->invitationsCount = $this->invitations->count();
        $this->applicationsCount = $this->applications->count();
    }

    public function mount()
    {
        $this->invitations = $this->user->teamInvitations;
        $this->invitationsCount = $this->invitations->count();

        $this->applications = $this->user->teamApplications;
        $this->applicationsCount = $this->applications->count();
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

        $this->emit('project_action', "Invitation accepted");

        $this->invitations = $this->invitations->fresh();
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

        $this->emit('project_action', "Invitation denied");

        $this->invitations = $this->invitations->fresh();
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
