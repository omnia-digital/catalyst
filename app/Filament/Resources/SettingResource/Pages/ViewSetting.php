<?php

namespace App\Filament\Resources\SettingResource\Pages;

use App\Filament\Resources\SettingResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSetting extends ViewRecord
{
    protected static string $resource = SettingResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
