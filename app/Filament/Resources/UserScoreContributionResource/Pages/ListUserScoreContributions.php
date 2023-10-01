<?php

namespace App\Filament\Resources\UserScoreContributionResource\Pages;

use App\Filament\Resources\UserScoreContributionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserScoreContributions extends ListRecords
{
    protected static string $resource = UserScoreContributionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
