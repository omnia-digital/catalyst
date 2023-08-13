<?php

namespace App\Filament\Resources\GameResource\Pages;

use App\Filament\Resources\GameResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageGames extends ManageRecords
{
    protected static string $resource = GameResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
