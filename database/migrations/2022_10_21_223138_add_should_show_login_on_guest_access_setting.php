<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration {
    public function up()
    {
        $this->migrator->add('general.should_show_login_on_guest_access', false, false);
    }
};
