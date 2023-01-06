<?php

namespace App\Filament\Pages;

use App\Filament\Resources\UserResource\Widgets\AdminUserStatsOverview;
use Filament\Facades\Filament;
use Filament\Pages\Dashboard as BasePage;

class Dashboard extends BasePage
{
    protected function getColumns(): int|array
    {
        return 4;
    }

    protected function getWidgets(): array
    {
        return [
            AdminUserStatsOverview::class
        ];
    }

    //    public static $icon = 'heroicon-o-home';
//
//    public static $title = 'Dashboard';
//
//    public static function getWidgets(): array
//    {
//        return [
//            Widgets\AccountWidget::class,
//            Widgets\FilamentInfoWidget::class,
//        ];
//    }
}
