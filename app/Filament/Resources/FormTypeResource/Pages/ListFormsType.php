<?php

namespace App\Filament\Resources\FormTypeResource\Pages;

use App\Filament\Resources\FormTypeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFormsType extends ListRecords
{
    protected static string $resource = FormTypeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
