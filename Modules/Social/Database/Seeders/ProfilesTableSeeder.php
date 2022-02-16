<?php

namespace Modules\Social\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Social\Models\Profile;

class ProfilesTableSeeder extends Seeder
{
    public function run()
    {
        Profile::truncate();

        Profile::factory(15)->create();

    }
}
