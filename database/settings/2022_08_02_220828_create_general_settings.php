<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateGeneralSettings extends SettingsMigration
{
    public function up(): void
    {
        if (Schema::hasTable('settings')) {
            return;
        }
        if (!$this->migrator->has('general.site_name')) {
            $this->migrator->add('general.site_name', env('APP_NAME', 'Platform'), false);
        }
        if (!$this->migrator->has('general.site_active')) {
            $this->migrator->add('general.site_active', true, false);
        }
    }
}
