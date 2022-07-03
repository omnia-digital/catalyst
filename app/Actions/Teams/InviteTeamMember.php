<?php

namespace App\Actions\Teams;

use App\Contracts\InvitesTeamMembers;
use App\Events\InvitingTeamMember;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\Mail\TeamInvitation;
use Laravel\Jetstream\Rules\Role;

class InviteTeamMember implements InvitesTeamMembers
{
    /**
     * Invite a new team member to the given team.
     *
     * @param  mixed  $inviter
     * @param  mixed  $team
     * @param  string  $email
     * @param  string|null  $role
     * @param  string  $message
     * @return void
     */
    public function invite($inviter, $team, string $email, string $role = null, string $message = '')
    {
        Gate::forUser($inviter)->authorize('addTeamMember', $team);

        $user = User::findByEmail($email);

        $this->validate($team, $email, $role, $message);

        InvitingTeamMember::dispatch($team, $email, $role, $message);

        $invitation = $team->teamInvitations()->create([
            'user_id' => optional($user)->id,
            'inviter_id' => $inviter->id,
            'email' => $email,
            'role' => $role,
            'message' => $message,
        ]);

        Mail::to($email)->send(new TeamInvitation($invitation));
    }

    /**
     * Validate the invite member operation.
     *
     * @param  mixed  $team
     * @param  string  $email
     * @param  string|null  $role
     * @param  string  $message
     * @return void
     */
    protected function validate($team, string $email, ?string $role, string $message)
    {
        Validator::make([
            'email' => $email,
            'role' => $role,
            'message' => $message,
        ], $this->rules($team), [
            'email.unique' => \Trans::get('This user has already been invited to the team.'),
        ])->after(
            $this->ensureUserIsNotAlreadyOnTeam($team, $email)
        )->validateWithBag('addTeamMember');
    }

    /**
     * Get the validation rules for inviting a team member.
     *
     * @param  mixed  $team
     * @return array
     */
    protected function rules($team)
    {
        return array_filter([
            'email' => ['required', 'email', Rule::unique('team_invitations')->where(function ($query) use ($team) {
                $query->where('team_id', $team->id);
            })],
            'role' => Jetstream::hasRoles()
                            ? ['required', 'string', new Role]
                            : null,
            'message' => ['max:255'],
        ]);
    }

    /**
     * Ensure that the user is not already on the team.
     *
     * @param  mixed  $team
     * @param  string  $email
     * @return \Closure
     */
    protected function ensureUserIsNotAlreadyOnTeam($team, string $email)
    {
        return function ($validator) use ($team, $email) {
            $validator->errors()->addIf(
                $team->hasUserWithEmail($email),
                'email',
                \Trans::get('This user already belongs to the team.')
            );
        };
    }
}