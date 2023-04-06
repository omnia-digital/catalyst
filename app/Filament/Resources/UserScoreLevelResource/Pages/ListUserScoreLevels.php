<?php

namespace App\Filament\Resources\UserScoreLevelResource\Pages;

use App\Filament\Resources\UserScoreLevelResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserScoreLevels extends ListRecords
{
    protected static string $resource = UserScoreLevelResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
