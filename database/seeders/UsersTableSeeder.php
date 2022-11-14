<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::truncate();

        User::factory(1)->withProfile()->withTeam()->create([
            'email' => 'admin@omniadigital.io',
            'password' => bcrypt('testing'),
            'is_admin' => true
        ]);

        User::factory(1)->withProfile()->withExistingTeam()->create([
            'email' => 'teammember@test.com',
            'password' => bcrypt('testing')
        ]);

        User::factory(1)->withProfile()->withExistingTeam()->create([
            'email' => 'jondoe@test.com',
            'password' => bcrypt('testing')
        ]);

        User::factory(1)->withProfile()->withExistingTeam()->create([
            'email' => 'janedoe@test.com',
            'password' => bcrypt('testing')
        ]);

        User::factory(1)->withProfile()->withTeam()->create([
            'email' => 'teamowner@test.com',
            'password' => bcrypt('testing')
        ]);

        User::factory(1)->withProfile()->withExistingTeam()->create([
            'email' => 'teammember2@test.com',
            'password' => bcrypt('testing')
        ]);

        User::factory(1)->withProfile()->withExistingTeam()->create([
            'email' => 'teammember3@test.com',
            'password' => bcrypt('testing')
        ]);

        User::factory(1)->withProfile()->withExistingTeam()->create([
            'email' => 'teammember4@test.com',
            'password' => bcrypt('testing')
        ]);


        User::factory(10)->withProfile()->withTeam()->create();

    }
}
