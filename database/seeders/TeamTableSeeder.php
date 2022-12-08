<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
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
                     ->withUsers(2)
                     ->create();

        foreach ($teams as $team) {
            $team->attachTags(['Curated','Popular','Indie'], 'team');
            $team->attachTags(['Church','Missionary','Non-Profit Organization'], 'team_type');
        }
    }
}
