<?php

namespace Modules\Social\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Social\Models\UserScoreContribution;
use OmniaDigital\CatalystCore\Facades\Translate;

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
            'name' => Translate::get('Created Team'),
            'points' => 100,
        ]);
    }
}
