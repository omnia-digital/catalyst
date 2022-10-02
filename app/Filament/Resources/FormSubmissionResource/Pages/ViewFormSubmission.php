<?php

namespace App\Filament\Resources\FormSubmissionResource\Pages;

use App\Filament\Resources\FormResource;
use App\Filament\Resources\FormSubmissionResource;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;
use Modules\Forms\Models\Form;

class ViewFormSubmission extends ViewRecord
{
    protected static string $resource = FormSubmissionResource::class;

    public $data = [];

    protected function mutateFormDataBeforeFill(array $submissionObject): array
    {
        foreach($submissionObject['data'] as $key => $value) {
            if (is_array($value) && isset($value['data'])) {
                $submissionObject['data'][$key] = $value['data'];
            }
        }

        return $submissionObject['data'];
    }

    protected function getFormSchema(): array
    {
        $formModel          = $this->record->form;
        $formData           = $this->record->data;
        $formModelFields    = collect($formModel->content);
        $form_team_id       = $formModel->team_id;
        $submission_team_id = $this->record->team_id;

        // in order to get the label of the field, we need to pull the field from the form model
        // then we can create the field with the correct values
        $fields = collect();
        $formattedData = collect();
        foreach ($formData as $formDataKey => $formDataValue) {
            $data = $formDataValue['data'];

            // figure out which fields to show based on key
            $formFieldKeyFound = $formModelFields->search(function ($formModelField, $formModelFieldKey) use ($formDataKey) {
                if ($formModelField['data']['name'] === $formDataKey) {
                    return true;
                }
            });
            // that way we can get the correct label if it exists
            $formFieldLabel = $formModelFields[$formFieldKeyFound]['data']['label'] ?? "(no label found in form)";
            // NOTE: We use field_type of the submission here because the field might be deleted on the form, but we still want to show the right type of data from the submission, which is also why
            // we save the field_type in the submission data
            $fields->push(match ($formDataValue['field_type']) {
                'text' => TextInput::make($formDataKey)
                                   ->label($formFieldLabel),
                'select' => Select::make($formDataKey)
                                  ->label($formFieldLabel)
                                  ->options($data['options']),
                'checkbox' => Checkbox::make($formDataKey)
                                      ->label($formFieldLabel),
                'file' => FileUpload::make($formDataKey)
                                    ->label($formFieldLabel)
                                    ->multiple($data['is_multiple']),
            });
//            $formattedData->put($formDataKey, $data);
        }

        return $fields->toArray();
    }

    protected function getFormStatePath(): ?string
    {
        // All of the form data needs to be saved in the `data` property,
        // as the form is dynamic and we can't add a public property for
        // every field.
        return 'data';
    }

    protected function getActions(): array
    {
        return [

            Actions\EditAction::make(),
        ];
    }
}
