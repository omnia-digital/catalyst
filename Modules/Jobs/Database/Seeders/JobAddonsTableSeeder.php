<?php

namespace Modules\Jobs\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Jobs\Models\JobPositionAddon;

class JobAddonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        JobPositionAddon::create([
                             'name' => 'Highlight',
                             'code' => 'highlight-job',
                             'description' => 'Add a highlight to your job to make it stand out',
                             'price' => 30.00
                         ]);

        JobPositionAddon::create([
                             'name' => 'Featured',
                             'code' => 'featured-job',
                             'description' => 'Add your job to the Featured section at the top of the listings as a full card. Let contractors know that you mean business.',
                             'price' => 49.00
                         ]);

        JobPositionAddon::create([
                             'name' => 'Show Company Logo',
                             'code' => 'show-company-logo',
                             'description' => 'Brand your listing with your company logo for both instant recognition and getting your brand out there.',
                             'price' => 29.00
                         ]);
    }
}
