<?php

namespace App\Actions\Teams;

use App\Models\Team;
use App\Support\Platform\Platform;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Contracts\CreatesTeams;
use Laravel\Jetstream\Events\AddingTeam;
use Laravel\Jetstream\Jetstream;
use Spatie\Permission\Models\Role;

class CreateTeam implements CreatesTeams
{
    public function create($user, array $input): Team
    {
        Gate::forUser($user)->authorize('create', Jetstream::newTeamModel());

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
        ])->validateWithBag('createTeam');

        AddingTeam::dispatch($user);

        $team = Team::create([
            'name' => $input['name'],
        ]);

        // Roles
        // Create an owner and member role for the new team
        // Assign the Owner role to the user who just created the team
        $roleOwner = Role::create([
            'name' => config('platform.teams.default_owner_role'),
            'team_id' => $team->id,
        ]);
        $roleMember = Role::create([
            'name' => config('platform.teams.default_member_role'),
            'team_id' => $team->id,
        ]);

        $team->users()->attach(
            $user, ['role_id' => $roleOwner->id]
        );

        // Team types
        if (! empty($input['teamTypes'])) {
            $team->attachTags($input['teamTypes']);
        }

        if (! empty($input['bannerImage'])) {
            $team->addMedia($input['bannerImage'])->toMediaCollection('team_banner_images');
        }
        if (! empty($input['mainImage'])) {
            $team->addMedia($input['mainImage'])->toMediaCollection('team_main_images');
        }
        if (! empty($input['profilePhoto'])) {
            $team->addMedia($input['profilePhoto'])->toMediaCollection('team_profile_photos');
        }

        if (! empty($input['sampleMedia'])) {
            foreach ($input['sampleMedia'] as $media) {
                $team->addMedia($media)->toMediaCollection('team_sample_images');
            }
        }

        if (Platform::isUsingTeamMemberSubscriptions()) {
            (new CreateStripeConnectAccountForTeamAction)->execute($team);
        }

        $user->switchTeam($team);

        return $team;
    }
}
