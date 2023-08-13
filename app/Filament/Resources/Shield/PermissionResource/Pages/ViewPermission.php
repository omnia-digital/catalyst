<?php

namespace App\Filament\Resources\Shield\PermissionResource\Pages;

use App\Filament\Resources\Shield\PermissionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPermission extends ViewRecord
{
    protected static string $resource = PermissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
