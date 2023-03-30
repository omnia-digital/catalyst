<?php

namespace Modules\Social\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class SocialDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(PostsTableSeeder::class);
        $this->call(BookmarksTableSeeder::class);
        $this->call(MentionsTableSeeder::class);
    }
}
