<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Livestream\Models\Episode;

class EpisodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Episode::factory()->count(20)->create();
    }
}
