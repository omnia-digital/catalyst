<?php namespace Modules\Forms\Traits\Livewire;

use App\Models\Team;
use Closure;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Illuminate\Support\Str;
use Modules\Forms\Models\Form;
use Modules\Forms\Models\FormType;
use OmniaDigital\OmniaLibrary\Livewire\WithNotification;
use Trans;

/**
 * Add form builder to livewire component
 */
trait WithFormBuilder
{
    use InteractsWithForms, WithNotification;

    public $name;
    public $slug;
    public $content;
    public $team_id;
    public $form_type_id;

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('name')
                    ->label('Name')
                    ->required(true),
            Select::make('form_type_id')
                ->label('Form Type')
                ->options(FormType::pluck('name', 'id')->toArray()),
            TextInput::make('slug')
                ->label('Slug')
                ->required(true)
                ->hint("<p class='hint-text'>Once created, you cannot change this value.</p>")
                ->columnSpan(2),
            Builder::make('content')
                ->columnSpan(2)
                ->blocks([
                    Block::make('text')
                        ->label('Text input')
                        ->icon('heroicon-o-annotation')
                        ->schema([
                            $this->getFieldNameInput(),
                            Checkbox::make('is_required'),
                            Select::make('type')
                                ->options([
                                    'email' => 'Email',
                                    'password' => 'Password',
                                    'text' => 'Text',
                                ])
                                ->default('text')
                                ->disablePlaceholderSelection()
                                ->required()
                        ]),
                    Block::make('select')
                        ->icon('heroicon-o-selector')
                        ->schema([
                            $this->getFieldNameInput(),
                            KeyValue::make('options')
                                    ->addButtonLabel('Add option')
                                    ->keyLabel('Value')
                                    ->valueLabel('Label'),
                            Checkbox::make('is_required'),
                        ]),
                    Block::make('checkbox')
                        ->icon('heroicon-o-check-circle')
                        ->schema([
                            $this->getFieldNameInput(),
                            Checkbox::make('is_required'),
                        ]),
                    Block::make('file')
                        ->icon('heroicon-o-photograph')
                        ->schema([
                            $this->getFieldNameInput(),
                            Grid::make()
                                ->schema([
                                    Checkbox::make('is_multiple'),
                                    Checkbox::make('is_required'),
                                ]),
                        ]),
                ])
                ->createItemButtonLabel('Add Form Element')
                ->disableLabel(),
        ];
    }

    protected function getFieldNameInput(): Grid
    {
        // This is not a Filament-specific method, simply saves on repetition
        // between our builder blocks.
        return Grid::make()
            ->schema([
                TextInput::make('name')
                    ->lazy()
                    ->afterStateUpdated(function (\Closure $set, $state) {
                        $label = Str::of($state)
                                    ->kebab()
                                    ->replace(['-', '_'], ' ')
                                    ->ucfirst();
                        $set('label', $label);
                    })
                    ->required(),
                TextInput::make('label')
                    ->required(),
            ]);
    }
    
    public function save($teamId = null): void
    {
        $form = $this->form->getState();

        $formData = [
            'name' => $form['name'], 
            'slug' => $form['slug'], 
            'form_type_id' => $form['form_type_id'], 
            'team_id' => $teamId,
            'content' => $form['content']
        ];

        if ($this->formModel) {
            $this->formModel->update($formData);
        } else {
            Form::create($formData);
        }

        $this->success(Trans::get('Form created successfully'));

        if ($teamId) {
            $this->redirectRoute('social.teams.admin', Team::find($teamId));
        } else {
            $this->redirectRoute('social.home');
        }

    }
}
