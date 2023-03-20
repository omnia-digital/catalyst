<?php

namespace App\Filament\Pages;

use App\Filament\Resources\UserResource\Widgets\AdminUserStatsOverview;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Pages\Dashboard as BasePage;
use Filament\Widgets\AccountWidget;

class Dashboard extends BasePage
{
    protected function getColumns(): int|array
    {
        return 4;
    }

    protected function getWidgets(): array
    {
        return [
            AccountWidget::class,
            AdminUserStatsOverview::class,
        ];
    }
}
