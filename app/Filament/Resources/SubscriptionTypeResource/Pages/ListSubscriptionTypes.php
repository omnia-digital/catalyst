<?php

namespace App\Filament\Resources\SubscriptionTypeResource\Pages;

use App\Filament\Resources\SubscriptionTypeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSubscriptionTypes extends ListRecords
{
    protected static string $resource = SubscriptionTypeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
