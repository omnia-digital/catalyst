<?php

namespace App\Filament\Resources\UserScoreContributionResource\Pages;

use App\Filament\Resources\UserScoreContributionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserScoreContribution extends EditRecord
{
    protected static string $resource = UserScoreContributionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
