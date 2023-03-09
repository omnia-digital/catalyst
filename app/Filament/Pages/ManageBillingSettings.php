<?php

namespace App\Filament\Pages;

use App\Filament\Resources\UserResource\Widgets\AdminUserStatsOverview;
use App\Settings\BillingSettings;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Pages\Actions\Action;
use Filament\Pages\SettingsPage;
use Filament\Widgets\StatsOverviewWidget;
use Illuminate\Support\Arr;
use Modules\Billing\Enums\PaymentGateway;
use Modules\Billing\Models\FormAssemblyForm;

class ManageBillingSettings extends SettingsPage
{
    use HasPageShield;
    
    protected static ?string $title = 'Billing';
    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static string $settings = BillingSettings::class;
    protected static ?string $navigationGroup = 'Settings';

    protected function getHeaderWidgets(): array
    {
        return [
            AdminUserStatsOverview::class
        ];
    }

    protected function getHeaderWidgetsColumns(): int | array
    {
        return 3;
    }

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
            Toggle::make('team_subscriptions')
                ->label('Use Team Subscriptions?')
                ->inline(false),
            Toggle::make('team_member_subscriptions')
                ->label('Use Team Member Subscriptions?')
                ->inline(false),
            Select::make('user_subscription_form')
                ->label('User Subscription Form')
                ->options(FormAssemblyForm::pluck('name', 'slug')->toArray())
                ->disablePlaceholderSelection(),
            Select::make('change_payment_method_form')
                ->label('Form To Change Payment Method For User Subscriptions')
                ->options(FormAssemblyForm::pluck('name', 'slug')->toArray())
                ->disablePlaceholderSelection(),
            Toggle::make('show_user_subscription_plan_in_navigation')
                ->label('Show User Subscription Plan in Left Navigation?')
                ->inline(false),
            Toggle::make('show_user_subscription_plan_in_profile_header')
                ->label('Show User Subscription Plan in Profile Header?')
                ->inline(false),
            TextInput::make('application_fee_percent')
                ->label('Application Fee Percent')
                ->numeric()
                ->minValue(0)
                ->maxValue(100),
        ];
    }
}
