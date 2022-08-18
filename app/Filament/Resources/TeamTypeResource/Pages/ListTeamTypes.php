<?php

namespace App\Filament\Resources\TeamTypeResource\Pages;

use App\Filament\Resources\TeamTypeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTeamTypes extends ListRecords
{
    protected static string $resource = TeamTypeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
