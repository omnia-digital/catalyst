<?php

namespace Modules\Jobs\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class JobPositionsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(TagsTableSeeder::class);
        $this->call(JobAddonsTableSeeder::class);
    }
}
