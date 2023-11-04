<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use OmniaDigital\CatalystCore\Database\Seeders\CatalystDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(CatalystDatabaseSeeder::class);
    }
}
