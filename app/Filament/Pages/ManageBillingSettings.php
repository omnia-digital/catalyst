<?php

namespace App\Filament\Pages;

use App\Settings\BillingSettings;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Pages\SettingsPage;
use Illuminate\Support\Arr;
use Modules\Subscriptions\Enums\PaymentGateway;
use Modules\Subscriptions\Models\FormAssemblyForm;

class ManageBillingSettings extends SettingsPage
{
    protected static ?string $title = 'Billing';
    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static string $settings = BillingSettings::class;
    protected static ?string $navigationGroup = 'Settings';

    protected function getFormSchema(): array
    {
        return [
            Select::make('payment_gateway')
                ->label('Payment Gateway')
                ->options(Arr::pluck(PaymentGateway::cases(), 'name', 'value'))
                ->disablePlaceholderSelection(),
            Toggle::make('user_subscriptions')
                ->label('Use User Subscriptions?')
                ->inline(false),
            Select::make('user_subscription_form')
                ->label('User Subscription Form')
                ->options(FormAssemblyForm::pluck('name', 'slug')->toArray())
                ->disablePlaceholderSelection(),
        ];
    }
}