<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Social\Database\Seeders\PostsTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        if (DB::connection() instanceof \Illuminate\Database\MySqlConnection) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
        }

        $this->call(UsersTableSeeder::class);
        $this->call(PostsTableSeeder::class);
        $this->call(CommentsTableSeeder::class);
        
        if (DB::connection() instanceof \Illuminate\Database\MySqlConnection) {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }

        Model::reguard();
    }
}
