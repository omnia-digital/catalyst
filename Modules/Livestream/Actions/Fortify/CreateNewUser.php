<?php

namespace Modules\Livestream\Actions\Fortify;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Modules\Livestream\Models\Person;
use Modules\Livestream\Models\Team;
use Modules\Livestream\Models\User;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Create a newly registered user.
     *
     * @return \App\Models\User
     *
     * @throws ValidationException
     */
    public function create(array $input, bool $viaSocial = false, bool $validation = true)
    {
        if ($validation) {
            Validator::make($input, $this->rules($viaSocial))->validate();
        }

        return DB::transaction(function () use ($input, $viaSocial) {
            $person = Person::create([
                'first_name' => $input['first_name'],
                'last_name' => $input['last_name'],
                'email' => $input['email'],
            ]);

            /** @var User $user */
            $user = $person->user()->create([
                'email' => $input['email'],
                'password' => $viaSocial ? null : Hash::make($input['password']),
            ]);

            /** @var Team $team */
            $this->createTeam($user);

            // Create social account for user if needed
            if (isset($input['provider']) && isset($input['provider_user_id'])) {
                $sessionKey = $input['provider'] . $input['provider_user_id'];

                $socialUser = session()->get($sessionKey);

                $user->createSocialAccount($socialUser);
                $user->update(['avatar' => $socialUser->getAvatar()]);

                session()->forget($sessionKey);
            }

            return $user;
        });
    }

    /**
     * @return false|Model
     */
    protected function createTeam(User $user)
    {
        return $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => Team::DEFAULT_TEAM_NAME,
            'personal_team' => true,
        ]));
    }

    private function rules(bool $viaSocial): array
    {
        if ($viaSocial) {
            return [];
        }

        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ];
    }
}
