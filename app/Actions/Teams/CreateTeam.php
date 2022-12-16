<?php

namespace App\Actions\Teams;

use App\Models\Team;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Contracts\CreatesTeams;
use Laravel\Jetstream\Events\AddingTeam;
use Laravel\Jetstream\Jetstream;

class CreateTeam implements CreatesTeams
{
    public function create($user, array $input): Team
    {
        Gate::forUser($user)->authorize('create', Jetstream::newTeamModel());

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
//            'start_date' => ['required', 'date'],
//            'summary' => ['required', 'max:280'],
        ])->validateWithBag('createTeam');

        AddingTeam::dispatch($user);

        $team = $user->ownedTeams()->create([
            'name' => $input['name'],
//            'start_date' => $input['start_date'],
//            'summary' => $input['summary'],
        ]);

        // Roles
        // assign the creator the owner role
        setPermissionsTeamId($team->id);
        $user->assignRole(config('platform.teams.default_owner_role'));

        // Team types
        if (!empty($input['teamTypes'])) {
            $team->attachTags($input['teamTypes']);
        }

        $user->teams()->updateExistingPivot($team->id, ['role' => 'owner']);

        if ( ! empty($input['bannerImage'])) {
            $team->addMedia($input['bannerImage'])->toMediaCollection('team_banner_images');
        }
        if ( ! empty($input['mainImage'])) {
            $team->addMedia($input['mainImage'])->toMediaCollection('team_main_images');
        }
        if ( ! empty($input['profilePhoto'])) {
            $team->addMedia($input['profilePhoto'])->toMediaCollection('team_profile_photos');
        }

        if ( ! empty($input['sampleMedia'])) {
            foreach ($input['sampleMedia'] as $media) {
                $team->addMedia($media)->toMediaCollection('team_sample_images');
            }
        }

        (new CreateStripeConnectAccountForTeamAction)->execute($team);

        $user->switchTeam($team);

        return $team;
    }
}
