<?php

namespace Modules\Social\Database\Seeders;

use Modules\Social\Models\Bookmark;
use Modules\Social\Models\Post;
use Illuminate\Database\Seeder;

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
        Bookmark::factory(15)->create();
    }
}
