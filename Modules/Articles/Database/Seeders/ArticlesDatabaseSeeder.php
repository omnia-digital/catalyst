<?php

namespace Modules\Articles\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Social\Database\Seeders\BookmarksTableSeeder;
use Modules\Social\Models\Post;

class ArticlesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::factory(15)->asArticle()->create();
        $this->call(BookmarksTableSeeder::class);
    }
}
