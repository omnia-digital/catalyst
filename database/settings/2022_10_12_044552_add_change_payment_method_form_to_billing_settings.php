<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class AddChangePaymentMethodFormToBillingSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('billing.change_payment_method_form', 'change-payment-method');
    }
}
