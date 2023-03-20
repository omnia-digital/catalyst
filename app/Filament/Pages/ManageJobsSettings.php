<?php

namespace App\Filament\Pages;

use App\Settings\FooterSettings;
use App\Settings\GeneralSettings;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Pages\SettingsPage;
use Modules\Jobs\Settings\JobsSettings;

class ManageJobsSettings extends SettingsPage
{
    use HasPageShield;

    protected static ?string $title = 'Jobs Settings';
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static string $settings = JobsSettings::class;
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = -100;
    protected function getFormSchema(): array
    {
        return [
            TextInput::make('featured_days'),
            TextInput::make('featured_jobs_limit'),
            TextInput::make('posting_price'),
        ];
    }
}
