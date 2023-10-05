<?php

namespace App\Filament\Resources\FormTypeResource\Pages;

use App\Filament\Resources\FormTypeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewFormType extends ViewRecord
{
    protected static string $resource = FormTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [

            Actions\EditAction::make(),
        ];
    }
}
