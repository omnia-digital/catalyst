<?php

namespace App\Filament\Resources\AwardResource\Pages;

use App\Filament\Resources\AwardResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAward extends EditRecord
{
    protected static string $resource = AwardResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make('delete'),
        ];
    }
}
