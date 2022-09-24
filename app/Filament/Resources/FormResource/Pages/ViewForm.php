<?php

namespace App\Filament\Resources\FormResource\Pages;

use App\Filament\Resources\FormResource;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;
use Modules\Forms\Models\Form;

class ViewForm extends ViewRecord implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = FormResource::class;

    public $data = [];

    protected function getFormSchema(): array
    {
        $staticFields = [
            TextInput::make('name')
                    ->label('Name')
                    ->required(true)->disabled(),
            TextInput::make('slug')
                    ->label('Slug')
                    ->required(true)->disabled(),
        ];


        $dynamicFields = array_map(function (array $field) {
            $config = $field['data'];

            return match ($field['type']) {
                'text' => TextInput::make($config['name'])
                                   ->label($config['label'])
                                   ->required($config['is_required']),
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
        }, $this->record->content);

        $fields = array_merge($staticFields, $dynamicFields);

        return $fields;
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
