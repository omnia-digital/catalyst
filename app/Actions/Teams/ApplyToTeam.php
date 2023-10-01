<?php

namespace App\Actions\Teams;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Jetstream\Events\InvitedTeamMember;
use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\Rules\Role;
use Trans;

class ApplyToTeam
{
    /**
     * Apply to a team.
     *
     * @param  mixed  $team
     * @param  int  $userID
     * @return void
     */
    public function apply($team, $userID, string $role = null)
    {
        $this->validate($team, $userID, $role);

        //InvitedTeamMember::dispatch($team, $email, $role);

        $application = $team->teamApplications()->create([
            'user_id' => $userID,
            'role' => $role,
        ]);

        //Mail::to($email)->send(new TeamInvitation($invitation));
    }

    /**
     * Validate the invite member operation.
     *
     * @param  mixed  $team
     * @param  int  $userID
     * @return void
     */
    protected function validate($team, string $userID, ?string $role)
    {
        Validator::make([
            'user_id' => $userID,
            'role' => $role,
        ], $this->rules($team), [
            'user_id.unique' => Trans::get('You have already applied to this team.'),
        ])->after(
            $this->ensureUserIsNotAlreadyOnTeam($team, $userID)
        )->validateWithBag('addTeamMember');
    }

    /**
     * Get the validation rules for applying user.
     *
     * @param  mixed  $team
     * @return array
     */
    protected function rules($team)
    {
        return array_filter([
            'user_id' => [
                'required',
                Rule::unique('team_applications')->where(function ($query) use ($team) {
                    $query->where('team_id', $team->id);
                }),
            ],
            'role' => Jetstream::hasRoles()
                ? ['required', 'string', new Role]
                : null,
        ]);
    }

    /**
     * Ensure that the user is not already on the team.
     *
     * @param  mixed  $team
     * @return Closure
     */
    protected function ensureUserIsNotAlreadyOnTeam($team, string $userID)
    {
        $user = User::find($userID);

        return function ($validator) use ($team, $user) {
            $validator->errors()->addIf(
                $team->hasUser($user),
                'user_id',
                Trans::get('This user already belongs to the team.')
            );
        };
    }
}
