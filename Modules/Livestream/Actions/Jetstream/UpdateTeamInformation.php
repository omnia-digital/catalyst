<?php

namespace Modules\Livestream\Actions\Jetstream;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Contracts\UpdatesTeamNames;

class UpdateTeamInformation implements UpdatesTeamNames
{
    /**
     * Validate and update the given team's name.
     *
     * @param mixed $user
     * @param mixed $team
     * @return void
     */
    public function update($user, $team, array $input)
    {
        Gate::forUser($user)->authorize('update', $team);

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'logo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
        ])->validateWithBag('updateTeamName');

        if (isset($input['logo'])) {
            $team->updateLogo($input['logo']);
        }

        $team->forceFill([
            'name' => $input['name'],
            'phone' => $input['phone'],
            'city' => $input['city'],
            'state' => $input['state'],
        ])->save();
    }
}
