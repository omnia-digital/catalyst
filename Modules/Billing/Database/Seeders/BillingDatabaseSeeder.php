<?php

namespace Modules\Billing\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Billing\Models\FormAssemblyField;
use Modules\Billing\Models\FormAssemblyForm;
use Modules\Billing\Models\SubscriptionType;

class BillingDatabaseSeeder extends Seeder
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

        SubscriptionType::firstOrCreate([
            'name' => 'CfaN EA Member',
            'slug' => 'cfan-ea-member',
            'amount' => 2500,
        ]);

        SubscriptionType::firstOrCreate([
            'name' => 'Associate Evangelist',
            'slug' => 'associate-evangelist',
            'amount' => 3000,
        ]);

        SubscriptionType::firstOrCreate([
            'name' => 'Co-Evangelist',
            'slug' => 'co-evangelist',
            'amount' => 3500,
        ]);

        $subscriptionForm = FormAssemblyForm::firstOrCreate([
            'name' => 'User Subscriptions',
            'fa_form_id' => '5011856',
        ]);

        $paymentMethodForm = FormAssemblyForm::firstOrCreate([
            'name' => 'Change Payment Method',
            'fa_form_id' => '5015890',
        ]);

        FormAssemblyField::firstOrCreate(
            [
                'form_assembly_form_id' => $subscriptionForm->id,
                'name' => 'first_name',
            ],
            [
                'tfa_code' => 'tfa_2243',
                'enabled' => 1,
            ]
        );

        FormAssemblyField::firstOrCreate(
            [
                'form_assembly_form_id' => $subscriptionForm->id,
                'name' => 'last_name',
            ],
            [
                'tfa_code' => 'tfa_2244',
                'enabled' => 1,
            ]
        );

        FormAssemblyField::firstOrCreate(
            [
                'form_assembly_form_id' => $subscriptionForm->id,
                'name' => 'email',
            ],
            [
                'tfa_code' => 'tfa_2246',
                'enabled' => 1,
            ]
        );

        FormAssemblyField::firstOrCreate(
            [
                'form_assembly_form_id' => $subscriptionForm->id,
                'name' => 'contact_id',
            ],
            [
                'tfa_code' => 'tfa_2247',
                'enabled' => 1,
            ]
        );

        FormAssemblyField::firstOrCreate(
            [
                'form_assembly_form_id' => $subscriptionForm->id,
                'name' => 'chargent_order_id',
            ],
            [
                'tfa_code' => 'CHARGENT_ORDER_OBJECT_ID_628152',
                'enabled' => 1,
            ]
        );
    }
}
