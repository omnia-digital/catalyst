<?php

namespace Modules\Resources\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Social\Database\Seeders\BookmarksTableSeeder;
use Modules\Social\Models\Post;

class ResourcesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::factory(10)->asResource()->create();
        Post::factory(10)->asArticle()->create();
        $this->call(BookmarksTableSeeder::class);
    }
}
