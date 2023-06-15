<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::truncate();

        $adminUser = User::factory(1)->withProfile([
            'first_name' => 'Omnia',
            'last_name' => 'Admin',
        ])->withTeam()->create([
            'email' => 'admin@omniadigital.io',
            'password' => bcrypt('testing'),
        ]);

        Role::create(['name' => 'super-admin']);

        $adminUser->first()->assignRole('super-admin');

        User::factory(1)->withProfile([
            'first_name' => 'Team',
            'last_name' => 'Member1',
        ])->withExistingTeam()->create([
            'email' => 'teammember@test.com',
            'password' => bcrypt('testing'),
        ]);

        User::factory(1)->withProfile([
            'first_name' => 'Jon',
            'last_name' => 'Doe',
        ])->withExistingTeam()->create([
            'email' => 'jondoe@test.com',
            'password' => bcrypt('testing'),
        ]);

        User::factory(1)->withProfile([
            'first_name' => 'Jane',
            'last_name' => 'Doe',
        ])->withExistingTeam()->create([
            'email' => 'janedoe@test.com',
            'password' => bcrypt('testing'),
        ]);

        User::factory(1)->withProfile([
            'first_name' => 'Team',
            'last_name' => 'Owner',
        ])->withTeam()->create([
            'email' => 'teamowner@test.com',
            'password' => bcrypt('testing'),
        ]);

        User::factory(1)->withProfile([
            'first_name' => 'Team',
            'last_name' => 'Member 2',
        ])->withExistingTeam()->create([
            'email' => 'teammember2@test.com',
            'password' => bcrypt('testing'),
        ]);

        User::factory(1)->withProfile([
            'first_name' => 'Team',
            'last_name' => 'Member3',
        ])->withExistingTeam()->create([
            'email' => 'teammember3@test.com',
            'password' => bcrypt('testing'),
        ]);

        User::factory(1)->withProfile([
            'first_name' => 'Team',
            'last_name' => 'Member4',
        ])->withExistingTeam()->create([
            'email' => 'teammember4@test.com',
            'password' => bcrypt('testing'),
        ]);

        User::factory(10)->withProfile()->withTeam()->create();
    }
}
