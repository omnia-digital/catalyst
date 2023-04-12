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
    public ?string $change_payment_method_form;

    public ?string $show_user_subscription_plan_in_navigation;
    public ?string $show_user_subscription_plan_in_profile_header;

    public ?float $application_fee_percent;

    public static function group(): string
    {
        return 'billing';
    }
}
