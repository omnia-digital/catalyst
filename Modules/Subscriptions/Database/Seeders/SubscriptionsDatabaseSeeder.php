<?php

namespace Modules\Subscriptions\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Subscriptions\Models\FormAssemblyForm;
use Modules\Subscriptions\Models\SubscriptionType;

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

        SubscriptionType::create([
            'name' => 'Monthly',
            'slug' => 'monthly',
            'amount' => 2500,
        ]);

        FormAssemblyForm::create([
            'name' => 'User Subscriptions',
            'fa_form_id' => '5011856'
        ]);
    }
}