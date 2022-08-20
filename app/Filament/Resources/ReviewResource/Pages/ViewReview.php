<?php

namespace App\Filament\Resources\ReviewResource\Pages;

use App\Filament\Resources\ReviewResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewReview extends ViewRecord
{
    protected static string $resource = ReviewResource::class;

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
