<?php

namespace App\Filament\Resources\TeamTypeResource\Pages;

use App\Filament\Resources\TeamTypeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTeamType extends EditRecord
{
    protected static string $resource = TeamTypeResource::class;

    /**
     * @return (Actions\DeleteAction|Actions\ViewAction)[]
     *
     * @psalm-return array{0: Actions\ViewAction, 1: Actions\DeleteAction}
     */
    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make('view'),
            Actions\DeleteAction::make('delete'),
        ];
    }
}
