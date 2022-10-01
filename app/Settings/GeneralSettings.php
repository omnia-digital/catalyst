<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public string $site_name;
    public bool $site_active;
    public string $teams_apply_button_text;

    public static function group(): string
    {
        return 'general';
    }
}
