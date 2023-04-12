<?php

namespace Modules\Social\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Social\Models\Bookmark;

class BookmarksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        Bookmark::truncate();

        // Posts
        Bookmark::factory(25)->create();
    }
}
