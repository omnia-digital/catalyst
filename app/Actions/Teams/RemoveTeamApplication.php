<?php

namespace App\Actions\Teams;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\Rules\Role;
use Trans;

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
