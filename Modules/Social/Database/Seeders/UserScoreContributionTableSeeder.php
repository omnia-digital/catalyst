<?php

namespace Modules\Social\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Social\Models\UserScoreContribution;

class UserScoreContributionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        UserScoreContribution::create([
            'name' => 'Liked User Post',
            'points' => 10,
        ]);

        UserScoreContribution::create([
            'name' => \Trans::get('Created Team'),
            'points' => 100,
        ]);
    }
}
