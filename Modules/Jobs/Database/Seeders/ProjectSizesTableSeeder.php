<?php

namespace Modules\Jobs\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Jobs\Models\TeamSize;

class ProjectSizesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teamSizes = [
            [
                'title' => 'Large',
                'description' => 'Longer term or complex initiatives (ex. design and build a full website)',
                'order' => 0,
            ],
            ['title' => 'Medium', 'description' => 'Well-defined teams (ex. a landing page)', 'order' => 1],
            [
                'title' => 'Small',
                'description' => 'Quick and Straightforward tasks (ex. update text and images on a webpage)',
                'order' => 2,
            ],
        ];

        foreach ($teamSizes as $teamSize) {
            TeamSize::create($teamSize);
        }
    }
}
