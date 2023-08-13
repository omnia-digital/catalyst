<?php

namespace App\Filament\Resources\Shield\PermissionResource\Pages;

use App\Filament\Resources\Shield\PermissionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPermissions extends ListRecords
{
    protected static string $resource = PermissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
