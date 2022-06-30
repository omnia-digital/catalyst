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
            'start_date' => ['required', 'date'],
            'summary' => ['required', 'max:280'],
        ])->validateWithBag('createTeam');

        AddingTeam::dispatch($user);

        $team = $user->ownedTeams()->create([
            'name' => $input['name'],
            'start_date' => $input['start_date'],
            'summary' => $input['summary'],
        ]);

        $user->teams()->updateExistingPivot($team->id, ['role' => 'owner']);

        $team->addMedia($input['bannerImage'])->toMediaCollection('team_banner_images');
        $team->addMedia($input['mainImage'])->toMediaCollection('team_main_images');

        foreach ($input['sampleMedia'] as $media) {
            $team->addMedia($media)->toMediaCollection('team_sample_images');
        }

        $user->switchTeam($team);

        return $team;
    }
}
