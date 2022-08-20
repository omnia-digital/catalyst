<?php

namespace App\Filament\Resources\TeamResource\Pages;

use App\Filament\Resources\TeamResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTeam extends EditRecord
{
    protected static string $resource = TeamResource::class;

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
