<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class BillingSettings extends Settings
{
    public ?string $payment_gateway;

    public ?bool $user_subscriptions;
    public ?bool $team_subscriptions;
    public ?bool $team_member_subscriptions;

    public ?string $user_subscription_form;

    public ?float $application_fee_percent;

    public static function group(): string
    {
        return 'billing';
    }
}
