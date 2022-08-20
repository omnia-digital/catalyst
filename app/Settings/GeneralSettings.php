<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{

    /**
     * @return string
     *
     * @psalm-return 'general'
     */
    public static function group(): string
    {
        return 'general';
    }
}
