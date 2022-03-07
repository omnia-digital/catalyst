<?php

namespace Modules\Resources\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
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
//        Model::unguard();

//        Post::factory(10)->withType('resource');

        Post::factory(15)->create([
            'type' => 'resource'
        ]);
    }
}