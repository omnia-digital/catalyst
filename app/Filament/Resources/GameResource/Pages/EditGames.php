<?php

namespace App\Filament\Resources\GameResource\Pages;

use App\Filament\Resources\GameResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGames extends EditRecord
{
    protected static string $resource = GameResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
