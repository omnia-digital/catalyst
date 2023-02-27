<?php

namespace App\Actions\Fortify;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param mixed $user
     * @param array $input
     * @return void
     */
    public function update($user, array $input)
    {
        Validator::make($input, [
            'person.first_name' => ['required', 'string', 'max:255'],
            'person.last_name'  => ['required', 'string', 'max:255'],
            'email'             => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo'             => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
        ], [
            'person.first_name.required' => 'The First Name field is required.',
            'person.last_name.required'  => 'The Last Name field is required.',
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->person->forceFill([
                'first_name' => $input['person']['first_name'],
                'last_name'  => $input['person']['last_name'],
                'email'      => $input['email']
            ])->save();

            $user->forceFill([
                'email' => $input['email'],
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param mixed $user
     * @param array $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $person = $user->person;
        $person->forceFill([
            'first_name' => $input['person']['first_name'],
            'last_name'  => $input['person']['last_name']
        ])->save();

        $user->forceFill([
            'email'             => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
