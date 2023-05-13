<?php

namespace App\Filament\Resources\FeedSourceResource\Pages;

use App\Filament\Resources\FeedSourceResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFeedSource extends EditRecord
{
    protected static string $resource = FeedSourceResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
