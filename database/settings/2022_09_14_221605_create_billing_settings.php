<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateBillingSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('billing.payment_gateway', 'stripe');
        $this->migrator->add('billing.user_subscriptions', 0);
        $this->migrator->add('billing.team_subscriptions', 0);
        $this->migrator->add('billing.team_member_subscriptions', 0);
        $this->migrator->add('billing.user_subscription_form', 'user-subscriptions');
    }
}
