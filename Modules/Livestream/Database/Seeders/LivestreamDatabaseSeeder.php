<?php

namespace Modules\Livestream\Database\Seeders;

use Database\Seeders\UserSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class LivestreamDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call([
            UserSeeder::class
        ]);    }
}
