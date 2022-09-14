<?php

namespace App\Filament\Pages;

use App\Settings\FooterSettings;
use App\Settings\GeneralSettings;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;

class ManageGeneralSettings extends SettingsPage
{
    protected static ?string $title = 'General Settings';
    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static string $settings = GeneralSettings::class;
    protected static ?string $navigationGroup = 'Settings';

    public function mount(): void
    {
        $this->form->fill([
            'authorId' => $this->record->author->id,
        ]);
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('site_name')
                ->required(),
            Select::make('Payment Gateway')
                ->options([
                    'chargent' => 'Chargent',
                    'stripe' => 'Stripe'
                ])
                ->default('stripe')
                ->disablePlaceholderSelection()
        ];
    }
}
