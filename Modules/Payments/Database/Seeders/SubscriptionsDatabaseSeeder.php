<?php

namespace Modules\Payments\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Payments\Models\FormAssemblyForm;
use Modules\Payments\Models\SubscriptionType;

class SubscriptionsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        SubscriptionType::query()->delete();

        SubscriptionType::create([
            'name' => 'CfaN EA Member',
            'slug' => 'cfan-ea-member',
            'amount' => 2500,
        ]);
        
        SubscriptionType::create([
            'name' => 'Associate Evangelist',
            'slug' => 'associate-evangelist',
            'amount' => 2500,
        ]);
        
        SubscriptionType::create([
            'name' => 'Co-Evangelist',
            'slug' => 'co-evangelist',
            'amount' => 2500,
        ]);
        
        SubscriptionType::create([
            'name' => 'Partner Evangelist',
            'slug' => 'partner-evangelist',
            'amount' => 2500,
        ]);

        FormAssemblyForm::firstOrCreate([
            'name' => 'User Subscriptions',
            'fa_form_id' => '5011856'
        ]);
    }
}
