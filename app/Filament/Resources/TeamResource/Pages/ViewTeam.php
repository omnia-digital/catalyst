<?php

namespace App\Filament\Resources\TeamResource\Pages;

use App\Filament\Resources\TeamResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTeam extends ViewRecord
{
    protected static string $resource = TeamResource::class;

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
