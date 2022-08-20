<?php

namespace App\Filament\Resources\ReviewResource\Pages;

use App\Filament\Resources\ReviewResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReview extends EditRecord
{
    protected static string $resource = ReviewResource::class;

    /**
     * @return (Actions\DeleteAction|Actions\ViewAction)[]
     *
     * @psalm-return array{0: Actions\ViewAction, 1: Actions\DeleteAction}
     */
    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
