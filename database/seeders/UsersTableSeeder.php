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
            'password' => bcrypt('testing')
        ]);

        User::factory(1)->withProfile()->withTeam()->create([
            'email' => 'teammember@test.com',
            'password' => bcrypt('testing')
        ]);

        User::factory(15)->withProfile()->withTeam()->create();

    }
}
