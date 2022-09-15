<?php

namespace App\Filament\Pages;

use App\Settings\BillingSettings;
use Filament\Pages\SettingsPage;

class ManageBillingSettings extends SettingsPage
{
    protected static ?string $title = 'Billing';
    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static string $settings = BillingSettings::class;
    protected static ?string $navigationGroup = 'Settings';

    protected function getFormSchema(): array
    {
        return [
            // ...
        ];
    }
}
