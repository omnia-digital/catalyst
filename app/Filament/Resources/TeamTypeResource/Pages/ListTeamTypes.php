<?php

namespace App\Filament\Resources\TeamTypeResource\Pages;

use App\Filament\Resources\TeamTypeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTeamTypes extends ListRecords
{
    protected static string $resource = TeamTypeResource::class;

    /**
     * @return Actions\CreateAction[]
     *
     * @psalm-return array{0: Actions\CreateAction}
     */
    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
