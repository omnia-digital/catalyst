<?php

namespace Modules\Jobs\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Jobs\Models\Tag;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = [
            'Tailwind',
            'Laravel',
            'Livewire',
            'Boostrap',
            'AlpineJs',
            'jQuery',
            'VueJs',
            'React',
        ];

        foreach ($tags as $tag) {
            Tag::create(['name' => $tag]);
        }
    }
}
