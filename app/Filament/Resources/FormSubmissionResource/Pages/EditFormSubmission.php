<?php

namespace App\Filament\Resources\FormSubmissionResource\Pages;

use App\Filament\Resources\FormSubmissionResource;
use Filament\Resources\Pages\EditRecord;

class EditFormSubmission extends EditRecord
{
    protected static string $resource = FormSubmissionResource::class;
    
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['data'] = json_decode($data['data']);

        return $data;
    }
}
