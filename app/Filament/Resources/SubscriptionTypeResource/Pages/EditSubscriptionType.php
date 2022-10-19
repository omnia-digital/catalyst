<?php

namespace App\Filament\Resources\SubscriptionTypeResource\Pages;

use App\Filament\Resources\SubscriptionTypeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubscriptionType extends EditRecord
{
    protected static string $resource = SubscriptionTypeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
