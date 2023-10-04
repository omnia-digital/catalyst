<?php

namespace App\Traits\Team;

use App\Actions\Teams\ApplyToTeam;
use App\Actions\Teams\RemoveTeamApplication;
use App\Contracts\InvitesTeamMembers;
use App\Models\TeamApplication;
use App\Models\TeamInvitation;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Laravel\Jetstream\Contracts\AddsTeamMembers;
use Laravel\Jetstream\Contracts\RemovesTeamMembers;
use Laravel\Jetstream\Features;
use Laravel\Jetstream\Jetstream;
use Modules\Social\Notifications\ApplicationAcceptedToTeamNotification;
use Modules\Social\Notifications\NewApplicationToTeamNotification;
use Modules\Social\Notifications\NewMemberOfMyTeamNotification;
use OmniaDigital\OmniaLibrary\Livewire\WithNotification;
use Spatie\Permission\Models\Role;
use OmniaDigital\CatalystCore\Facades\Translate;

trait WithTeamManagement
{
    use WithNotification;

    /**
     * Indicates if a user's role is currently being managed.
     *
     * @var bool
     */
    public $currentlyManagingRole = false;

    /**
     * The user that is having their role managed.
     *
     * @var mixed
     */
    public $managingRoleFor;

    /**
     * The current role for the user that is having their role managed.
     *
     * @var string
     */
    public $currentRole;

    /**
     * Indicates if the application is confirming if a user wishes to leave the current team.
     *
     * @var bool
     */
    public $confirmingLeavingTeam = false;

    /**
     * Indicates if the application is confirming if a team member should be removed.
     *
     * @var bool
     */
    public $confirmingTeamMemberRemoval = false;

    /**
     * The ID of the team member being removed.
     *
     * @var int|null
     */
    public $teamMemberIdBeingRemoved = null;

    /**
     * The "add team member" form state.
     *
     * @var array
     */
    public $addTeamMemberForm = [
        'email' => '',
        'role' => null,
        'message' => '',
    ];

    /**
     * Apply to a team.
     *
     * @return void
     */
    public function applyToTeam()
    {
        Gate::authorize('apply', $this->team);

        app(ApplyToTeam::class)->apply(
            $this->team,
            $this->user->id,
            'member'
        );

        $this->team->owner->notify(new NewApplicationToTeamNotification($this->team, $this->user));
        $this->success(Translate::get('Application Submitted to Team'));
        $this->dispatch('applied_to_team');
    }

    public function teamHasApplicationForm()
    {
        return ! is_null($this->team->applicationForm());
    }

    /**
     * Remove application to a team.
     *
     * @return void
     */
    public function removeApplication()
    {
        app(RemoveTeamApplication::class)
            ->remove($this->team, $this->user->id);

        $this->team = $this->team->fresh();

        $this->success(Translate::get('Application Removed'));
        $this->dispatch('application_removed');
    }

    /**
     * Add a new member to a team.
     *
     * @return void
     */
    public function addTeamMember()
    {
        $this->resetErrorBag();

        if (Features::sendsTeamInvitations()) {
            app(InvitesTeamMembers::class)->invite(
                $this->user,
                $this->team,
                $this->addTeamMemberForm['email'],
                $this->addTeamMemberForm['role'],
                $this->addTeamMemberForm['message']
            );
        } else {
            app(AddsTeamMembers::class)->add(
                $this->user,
                $this->team,
                $this->addTeamMemberForm['email'],
                $this->addTeamMemberForm['role']
            );
        }

        $this->addTeamMemberForm = [
            'email' => '',
            'role' => null,
            'message' => '',
        ];

        $this->team = $this->team->fresh();

        $this->success(Translate::get('Team info saved!'));
        $this->dispatch('saved');
    }

    /**
     * Add a new team member to a team with their userID.
     *
     * @param  string  $userID
     * @return void
     */
    public function addTeamMemberUsingID($userID)
    {
        $this->resetErrorBag();

        $user = User::find($userID);

        app(AddsTeamMembers::class)->add(
            $this->user,
            $this->team,
            $user->email,
            config('platform.teams.default_member_role')
        );

        $this->team->teamApplications()->where('user_id', $userID)->delete();

        $this->team = $this->team->fresh();

        $user->notify(new ApplicationAcceptedToTeamNotification($this->team, $user));

        $ownerAndAdmins = $this->team->admins->merge([$this->team->owner]);

        foreach ($ownerAndAdmins as $admin) {
            $admin->notify(new NewMemberOfMyTeamNotification($this->team, $user));
        }

        $this->success(Translate::get('Team member added!'));
        $this->dispatch('member_added');
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
            TeamApplication::find($applicationId)->delete();
        }

        //ToDo: Add Notification to user
        $this->team = $this->team->fresh();
    }

    /**
     * Cancel a pending team member invitation.
     *
     * @param  int  $invitationId
     * @return void
     */
    public function cancelTeamInvitation($invitationId)
    {
        if (! empty($invitationId)) {
            TeamInvitation::find($invitationId)->delete();
        }

        $this->success(Translate::get('Invitation removed.'));
        $this->team = $this->team->fresh();
    }

    /**
     * Remove the currently authenticated user from the team.
     *
     * @return void
     */
    public function leaveTeam(RemovesTeamMembers $remover)
    {
        $remover->remove(
            $this->user,
            $this->team,
            $this->user
        );

        $this->confirmingLeavingTeam = false;

        $this->team = $this->team->fresh();
        $this->success(Translate::get('You left the team.'));
    }

    /**
     * Confirm that the given team member should be removed.
     *
     * @param  int  $userId
     * @return void
     */
    public function confirmTeamMemberRemoval($userId)
    {
        $this->confirmingTeamMemberRemoval = true;

        $this->teamMemberIdBeingRemoved = $userId;
    }

    /**
     * Remove a team member from the team.
     *
     * @return void
     */
    public function removeTeamMember(RemovesTeamMembers $remover)
    {
        $remover->remove(
            $this->user,
            $this->team,
            Jetstream::findUserByIdOrFail($this->teamMemberIdBeingRemoved)
        );

        $this->confirmingTeamMemberRemoval = false;

        $this->teamMemberIdBeingRemoved = null;

        $this->success(Translate::get('Team member removed.'));
        $this->team = $this->team->fresh();
    }

    /**
     * Allow the given user's role to be managed.
     *
     * @param  int  $userId
     * @return void
     */
    public function manageRole($userId)
    {
        $this->currentlyManagingRole = true;
        $this->managingRoleFor = Jetstream::findUserByIdOrFail($userId);
        $this->currentRole = $this->managingRoleFor->teamRole($this->team)->id ?? 'No Role';
    }

    /**
     * Save the role for the user being managed.
     *
     * @return void
     */
    public function updateUserRole()
    {
        Gate::authorize('updateTeamRole', $this->team);

        $this->managingRoleFor->roles()->detach($this->managingRoleFor->teamRole($this->team)->id);
        $this->managingRoleFor->roles()->attach($this->currentRole, ['team_id' => $this->team->id]);

        $this->team = $this->team->fresh();

        $this->stopManagingRole();
    }

    /**
     * Stop managing the role of a given user.
     *
     * @return void
     */
    public function stopManagingRole()
    {
        $this->currentlyManagingRole = false;
    }

    /**
     * Get the current user of the application.
     *
     * @return mixed
     */
    public function getUserProperty()
    {
        return auth()->user();
    }

    /**
     * Get the available team member roles.
     *
     * @return array
     */
    public function getRolesProperty()
    {
        return Role::where('team_id', $this->team->id)->get();
    }
}
