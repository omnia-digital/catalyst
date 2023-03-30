<?php

namespace Database\Seeders;

use Modules\Livestream\Actions\Fortify\CreateNewUser;
use Modules\Livestream\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminUser = (new CreateNewUser)->create([
            'email'             => 'admin@omniadigital.io',
            'first_name'        => 'Omnia',
            'last_name'         => 'Admin',
            'password'          => 'testing',
            'terms'             => 'accepted',
        ], false, false);

        $adminUser->email_verified_at = now();
        $adminUser->save();

        $team = $adminUser->currentTeam;
        $team->name = 'Omnia Admin';
        $team->phone = 1231231234;
        $team->city = 'Battle Ground';
        $team->state = 'WA';
        $team->save();
        $team->trialEndsAt(now()->addYear());

        User::factory(15);
    }
}
