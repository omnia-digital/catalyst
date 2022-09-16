<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class BillingSettings extends Settings
{
    public string $payment_gateway;

    public bool $user_subscriptions;

    public string $user_subscription_form;

    public static function group(): string
    {
        return 'billing';
    }
}