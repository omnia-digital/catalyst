<?php

namespace Modules\Forms\Http\Livewire;


use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;
use Modules\Forms\Models\FormSubmission;
use OmniaDigital\OmniaLibrary\Livewire\WithNotification;

class Form extends Component implements HasForms
{
    use InteractsWithForms, WithNotification;

    public \Modules\Forms\Models\Form $formModel;

    public $data = [];
    public ?int $team_id = null; // tells us which team the form submission is for in case this is a global form
    public bool $formSubmitted = false;
    public bool $needBootcamp = false;
    public string $submitText;

    public function mount(\Modules\Forms\Models\Form $form, int $team_id = null, $submitText = "Submit")
    {
        $this->formModel = $form;
        $this->team_id = $team_id;
        $this->submitText = $submitText;
        $this->form->fill();
    }

    protected function getFormSchema(): array
    {
        return array_map(function (array $field) {
            $config = $field['data'];

            $helperText = !is_null($config['helper_text']) ? "<p class='hint-text'>{$config['helper_text']}</p" : null;

            return match ($field['type']) {
                'text' => TextInput::make($config['name'])
                    ->label($config['label'])
                    ->required($config['is_required'])
                    ->helperText($helperText)
                    ->hint($config['hint'] ?? null)
                    ->type($config['type']),
                'select' => Select::make($config['name'])
                    ->label($config['label'])
                    ->options($config['options'])
                    ->required($config['is_required'])
                    ->helperText($helperText)
                    ->hint($config['hint'] ?? null),
                'checkbox' => Checkbox::make($config['name'])
                    ->label($config['label'])
                    ->required($config['is_required'])
                    ->helperText($helperText)
                    ->hint($config['hint'] ?? null),
                'file' => FileUpload::make($config['name'])
                    ->label($config['label'])
                    ->multiple($config['is_multiple'])
                    ->required($config['is_required'])
                    ->helperText($helperText)
                    ->hint($config['hint'] ?? null),
            };
        }, $this->formModel->content);
    }

    protected function getFormStatePath(): ?string
    {
        // All of the form data needs to be saved in the `data` property,
        // as the form is dynamic and we can't add a public property for
        // every field.
        return 'data';
    }

    public function submit(): void
    {
        $formData = $this->prepareFormData($this->form->getState());

        $this->processFormSubmission($formData);

        $this->afterSubmission();
    }

    public function prepareFormData($formData)
    {
        $formModelFields = collect($this->formModel->content);

        foreach($formData as $formDataKey => $value) {
            // Search Form Model fields for the field that matches the form data
            $formFieldKeyFound = $formModelFields->search(function($formModelField, $formModelFieldKey) use ($formDataKey) {
                if ($formModelField['data']['name'] === $formDataKey) {
                    return true;
                }
            });
            $formFieldType = $formModelFields[$formFieldKeyFound]['type'];
            $formData[$formDataKey] = [
                'field_type' => $formFieldType,
                'data' => $value
            ];
        }

        return $formData;
    }

    public function processFormSubmission($formData)
    {
        FormSubmission::create([
            'form_id' => $this->formModel->id,
            'user_id' => auth()->id(),
            'team_id' => $team_id ?? null,
            'data' => $formData,
        ]);
    }

    public function afterSubmission()
    {
        $this->formSubmitted = true;
        
        $this->success('Form submitted successfully');

        $this->redirectRoute('social.home');
    }

    public function render()
    {
        return view('forms::livewire.form');
    }
}
