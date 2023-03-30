<?php

namespace Modules\Social\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Social\Models\Post;

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

        // Posts
        Post::factory(15)->create();
        // Replies
        Post::factory(15)->create([
            'postable_id' => Post::all()->random()->id,
            'postable_type' => Post::class,
        ]);
    }
}
