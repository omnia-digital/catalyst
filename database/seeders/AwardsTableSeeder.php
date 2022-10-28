<?php

namespace Database\Seeders;

use App\Models\Award;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AwardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Award::truncate();

        $awards = Award::factory(10)->create();

        foreach (User::all() as $user) {
            $user->awards()->attach(
                $awards->random(rand(1, 3))->pluck('id')->toArray()
            );
        }

        foreach (Team::all() as $team) {
            $team->awards()->attach(
                $awards->random(rand(1, 3))->pluck('id')->toArray()
            );
        }
    }
}
