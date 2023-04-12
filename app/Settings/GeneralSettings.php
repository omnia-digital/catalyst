<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public string $site_name;
    public bool $site_active;
    public string $teams_apply_button_text;
    public bool $allow_guest_access;
    public bool $should_show_login_on_guest_access;

    public static function group(): string
    {
        return 'general';
    }
}
