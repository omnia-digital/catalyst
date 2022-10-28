<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;
use Illuminate\Support\Facades\Schema;

class CreateGeneralSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.site_name', env('APP_NAME', 'Platform'), false);
        $this->migrator->add('general.site_active', true, false);
        $this->migrator->add('general.teams_apply_button_text', config('teams.defaults.apply_button_text', 'Apply'), false);
    }
}
