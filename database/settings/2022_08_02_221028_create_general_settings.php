<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;
use Illuminate\Support\Facades\Schema;

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
