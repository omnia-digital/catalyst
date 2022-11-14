<?php

namespace App\Filament\Resources\FormSubmissionResource\Pages;

use App\Filament\Resources\FormSubmissionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateFormSubmission extends CreateRecord
{
    protected static string $resource = FormSubmissionResource::class;
        
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['data'] = json_decode($data['data']);

        return $data;
    }
}
