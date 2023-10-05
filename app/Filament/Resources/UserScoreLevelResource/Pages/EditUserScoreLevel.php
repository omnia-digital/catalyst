<?php

namespace App\Filament\Resources\UserScoreLevelResource\Pages;

use App\Filament\Resources\UserScoreLevelResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserScoreLevel extends EditRecord
{
    protected static string $resource = UserScoreLevelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
