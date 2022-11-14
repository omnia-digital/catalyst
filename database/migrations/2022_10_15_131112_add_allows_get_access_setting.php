<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration {
    public function up()
    {
        $this->migrator->add('general.allow_guest_access', false, false);
    }
};
