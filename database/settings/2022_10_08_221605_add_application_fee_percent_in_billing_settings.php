<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class AddApplicationFeePercentInBillingSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('billing.application_fee_percent', 10);
    }
}
