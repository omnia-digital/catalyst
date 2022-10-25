<?php

namespace Modules\Forms\Http\Livewire;

use App\Models\Team;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Support\Facades\Http;
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

    public function mount(\Modules\Forms\Models\Form $form, int $team_id = null)
    {
        $this->formModel = $form;
        $this->team_id = $team_id;
        $this->form->fill();
    }

    protected function getFormSchema(): array
    {
        return array_map(function (array $field) {
            $config = $field['data'];

            return match ($field['type']) {
                'text' => TextInput::make($config['name'])
                    ->label($config['label'])
                    ->required($config['is_required'])
                    ->type($config['type']),
                'select' => Select::make($config['name'])
                    ->label($config['label'])
                    ->options($config['options'])
                    ->required($config['is_required']),
                'checkbox' => Checkbox::make($config['name'])
                    ->label($config['label'])
                    ->required($config['is_required']),
                'file' => FileUpload::make($config['name'])
                    ->label($config['label'])
                    ->multiple($config['is_multiple'])
                    ->required($config['is_required']),
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
        $formData = $this->form->getState();
        $formModelFields = collect($this->formModel->content);
        $team_id = $this->team_id;

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

        $submission = FormSubmission::create([
            'form_id' => $this->formModel->id,
            'user_id' => auth()->id(),
            'team_id' => $team_id ?? null,
            'data' => $formData,
        ]);

        $this->processFormSubmission($submission);

        if ($submission) {
            $this->success('Form submitted successfully');
            $this->formSubmitted = true;
        }

        if ($this->team_id) {
            $this->redirectRoute('social.teams.show', $this->team_id);
        }

        $this->redirectRoute('social.home');
    }

    public function processFormSubmission($submission)
    {
        switch ($submission->form->formType->slug) {
            case 'registration':
                Http::withOptions([
                    'verify' => false
                ])->post(route('register'), $submission->data);
                break;
            
            default:
                # code...
                break;
        }
    }

    public function render()
    {
        return view('forms::livewire.form');
    }
}
