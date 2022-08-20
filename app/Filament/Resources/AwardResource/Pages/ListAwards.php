<?php

namespace App\Filament\Resources\AwardResource\Pages;

use App\Filament\Resources\AwardResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAwards extends ListRecords
{
    protected static string $resource = AwardResource::class;

    /**
     * @return Actions\CreateAction[]
     *
     * @psalm-return array{0: Actions\CreateAction}
     */
    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
