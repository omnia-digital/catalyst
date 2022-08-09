<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateGeneralSettings extends SettingsMigration
{
    public function up(): void
    {
        if (Schema::hasTable('settings')) {
            return;
        }
        $this->migrator->add('general.site_name', env('APP_NAME', 'Platform'), false);
        $this->migrator->add('general.site_active', true, false);
    }
}
