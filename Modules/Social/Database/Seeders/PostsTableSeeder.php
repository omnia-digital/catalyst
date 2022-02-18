<?php

namespace Modules\Social\Database\Seeders;

use Modules\Social\Models\Post;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::truncate();

        Post::factory(10)->create();
    }
}
