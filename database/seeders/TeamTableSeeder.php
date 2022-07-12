<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Tags\Tag;

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
                     ->hasAttached(User::factory(1)->withProfile(), ['role'=> 'owner'])
                     ->hasAttached(User::factory(3)->withProfile(), ['role'=> 'member'])
                     ->create();

        foreach ($teams as $team) {
            $team->attachTags(['curated','popular','indie'], 'team');
            $team->attachTags(['church','missionary','non-profit organization'], 'team_type');
        }
    }
}
