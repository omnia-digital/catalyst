<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\TeamLocation;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        //Team::truncate();

        $teams = Team::factory(10)->has(TeamLocation::factory(1))->create();

        foreach (User::all() as $user) {
            $user->teams()->attach(
                $teams->random(rand(1, 3))->pluck('id')->toArray()
            );
        }

    }
}
