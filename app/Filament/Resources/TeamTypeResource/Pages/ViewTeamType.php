<?php

namespace App\Filament\Resources\TeamTypeResource\Pages;

use App\Filament\Resources\TeamTypeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTeamType extends ViewRecord
{
    protected static string $resource = TeamTypeResource::class;

    /**
     * @return Actions\EditAction[]
     *
     * @psalm-return array{0: Actions\EditAction}
     */
    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
