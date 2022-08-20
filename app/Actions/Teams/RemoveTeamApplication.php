<?php

namespace App\Actions\Teams;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Jetstream\Contracts\InvitesTeamMembers;
use Laravel\Jetstream\Events\InvitingTeamMember;
use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\Mail\TeamInvitation;
use Laravel\Jetstream\Rules\Role;

class RemoveTeamApplication
{
    /**
     * Remove application for a user from the team.
     *
     * @param  mixed  $team
     * @param  int  $userID
     * @return void
     */
    public function remove($team, $userID)
    {
        $application = $team->teamApplications()
                        ->where('user_id', $userID)->first();

        if (! is_null($application)) {
            $application->delete();
        }
    }

    /**
     * Get the validation rules for applying user.
     *
     * @param mixed  $team
     *
     * @return (Role|\Illuminate\Validation\Rules\Unique|string)[][]
     *
     * @psalm-return array{user_id: array{0: 'required', 1: \Illuminate\Validation\Rules\Unique}, role?: array{0: 'required', 1: 'string', 2: Role}}
     */
    protected function rules($team): array
    {
        return array_filter([
            'user_id' => ['required', Rule::unique('team_applications')->where(function ($query) use ($team) {
                $query->where('team_id', $team->id);
            })],
            'role' => Jetstream::hasRoles()
                            ? ['required', 'string', new Role]
                            : null,
        ]);
    }

    /**
     * Ensure that the user is not already on the team.
     *
     * @param mixed  $team
     * @param string  $userID
     *
     * @return \Closure
     *
     * @psalm-return \Closure(mixed):void
     */
    protected function ensureUserIsNotAlreadyOnTeam($team, string $userID): \Closure
    {
        $user = User::find($userID);

        return function ($validator) use ($team, $user) {
            $validator->errors()->addIf(
                $team->hasUser($user),
                'user_id',
                \Trans::get('This user already belongs to the team.')
            );
        };
    }
}
