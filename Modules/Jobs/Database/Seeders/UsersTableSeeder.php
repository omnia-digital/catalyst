<?php namespace Modules\Jobs\Database\Seeders;

use Modules\Jobs\Models\Team;
use Modules\Jobs\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::factory()->create([
            'name'     => 'Admin',
            'email'    => 'admin@test.com',
            'password' => \Illuminate\Support\Facades\Hash::make('secret')
        ])->assignRole('Admin');

        $admin->ownedTeams()->save(Team::forceCreate([
            'user_id' => $admin->id,
            'name' => explode(' ', $admin->name, 2)[0]."'s Company",
            'personal_team' => true,
        ]));

        $admin->createAsStripeCustomer();

        $contractor = User::factory()->create([
            'name'     => 'Contractor',
            'password' => \Illuminate\Support\Facades\Hash::make('secret')
        ])->assignRole('Contractor');

        $contractor->ownedTeams()->save(Team::forceCreate([
            'user_id' => $contractor->id,
            'name' => explode(' ', $contractor->name, 2)[0]."'s Company",
            'personal_team' => true,
        ]));

        $contractor->createAsStripeCustomer();

        $client = User::factory()->create([
            'name'     => 'Client',
            'password' => \Illuminate\Support\Facades\Hash::make('secret')
        ])->assignRole('Client');

        $client->ownedTeams()->save(Team::forceCreate([
            'user_id' => $client->id,
            'name' => explode(' ', $client->name, 2)[0]."'s Company",
            'personal_team' => true,
        ]));

        $client->createAsStripeCustomer();
    }
}
