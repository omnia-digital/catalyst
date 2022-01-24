<?php

namespace Modules\Social\Database\Seeders;

use App\Models\Profile;
use Illuminate\Database\Seeder;

class ProfilesTableSeeder extends Seeder
{
    public function run()
    {
        Profile::truncate();

        Profile::factory(15)->create();

    }
}
