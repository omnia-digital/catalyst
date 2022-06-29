<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        //Team::truncate();

        $teams = Team::factory(10)->has(Location::factory(1))->create();

        foreach ($teams as $team) {
            $team->attachTags(['curated','popular','indie']);
        }

//        foreach (User::all() as $user) {
//            $user->teams()->attach(
//                $teams->random(rand(1, 3))->pluck('id')->toArray()
//            );
//        }

    }
}
