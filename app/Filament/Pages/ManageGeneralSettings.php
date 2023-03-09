<?php

namespace App\Filament\Pages;

use App\Settings\FooterSettings;
use App\Settings\GeneralSettings;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Pages\SettingsPage;

class ManageGeneralSettings extends SettingsPage
{
    use HasPageShield;

    protected static ?string $title = 'General Settings';
    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static string $settings = GeneralSettings::class;
    protected static ?string $navigationGroup = 'Settings';

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('site_name')
                     ->required(),
            TextInput::make('teams_apply_button_text')
                     ->required(),
            Toggle::make('allow_guest_access')
                  ->label('Allow Guest Access to Platform?')
                  ->inline(false),
            Toggle::make('should_show_login_on_guest_access')
                ->label('Show Login Modal/Page on Guest Access?')
                ->inline(false),
        ];
    }
}
