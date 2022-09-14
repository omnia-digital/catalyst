<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class BillingSettings extends Settings
{

    public static function group(): string
    {
        return 'billing';
    }
}
