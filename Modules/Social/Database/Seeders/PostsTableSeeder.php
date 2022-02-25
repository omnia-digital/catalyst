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

        Post::factory(15)->create();
        Post::factory(15)->create([
            'postable_id' => Post::all()->random()->id,
            'postable_type' => Post::class,
        ]);
    }
}
