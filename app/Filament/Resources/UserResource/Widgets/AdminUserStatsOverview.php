<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Models\Team;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class AdminUserStatsOverview extends BaseWidget
{
//    protected int | string | array $columnSpan = '4';

    public static function canView(): bool
    {
        return auth()->user()->is_admin;
    }
    protected function getCards(): array
    {
        return [
            Card::make('Total Users', User::count()),
            Card::make('Users in Teams', $this->getUsersWithTeams()),
        ];
    }

    private function getUsersWithTeams(): int
    {
        return User::query()->whereHas('teams')->count();
    }

}
