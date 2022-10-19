<?php

namespace App\Filament\Resources\FormResource\Pages;

use App\Filament\Resources\FormResource;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Str;

class EditForm extends EditRecord implements HasForms
{
    //    use InteractsWithForms;

    protected static string $resource = FormResource::class;

    protected function getFormSchema(): array
    {
        $staticFields = [
            TextInput::make('name')
                     ->label('Name')
                     ->required(true),
            TextInput::make('slug')
                     ->label('Slug')
                     ->required(true)
                     ->hint('Do not change this if this form has been sent to users because it is used in the form link, so any previous links sent will be broken.'),
            Select::make('form_type_id')
                  ->relationship('formType', 'name')
                  ->schema([
                      TextInput::make('name')
                               ->required(),
                      Textarea::make('slug'),
                  ]),
        ];

        $builderButton = [
            Builder::make('content')
                   ->blocks([
                       Block::make('text')
                            ->label('Text input')
                            ->icon('heroicon-o-annotation')
                            ->schema([
                                $this->getFieldNameInput(),
                                Checkbox::make('is_required'),
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
                   ->createItemButtonLabel('Add form input')
                   ->disableLabel()
        ];

        $fields = array_merge($staticFields, $builderButton);

        return $fields;
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
}
