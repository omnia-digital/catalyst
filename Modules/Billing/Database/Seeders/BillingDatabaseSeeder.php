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

        /// @TODO [Josh] - add a way to pull in default subscription types from the env file, separated by comma

        SubscriptionType::firstOrCreate([
            'name' => 'Basic',
            'slug' => 'basic',
            'amount' => 1900, // amount is in cents
        ]);

        SubscriptionType::firstOrCreate([
            'name' => 'Plus',
            'slug' => 'plus',
            'amount' => 2900,
        ]);

        SubscriptionType::firstOrCreate([
            'name' => 'Pro',
            'slug' => 'pro',
            'amount' => 9900,
        ]);

        // @TODO [Josh] - setup a way to pull in the form assembly form ids from the env file
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
