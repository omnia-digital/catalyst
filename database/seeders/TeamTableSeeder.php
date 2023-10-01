<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teams = Team::factory(10)
            ->has(Location::factory(1))
            ->withUsers(1, config('platform.teams.default_owner_role'))
            ->withUsers(2, config('platform.teams.default_member_role'))
            ->create();

        foreach ($teams as $team) {
            $team->attachTags(['Curated', 'Popular', 'Indie'], 'team');
            $team->attachTags(['Church', 'Missionary', 'Non-Profit Organization'], 'team_type');
        }
    }
}
