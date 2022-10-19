<?php

namespace App\Filament\Resources\FormTypeResource\Pages;

use App\Filament\Resources\FormResource;
use App\Filament\Resources\FormTypeResource;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;
use Modules\Forms\Models\Form;

class ViewFormType extends ViewRecord implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = FormTypeResource::class;

    public $data = [];

    protected function getFormSchema(): array
    {
        $fields = [
            TextInput::make('name')
                    ->label('Name')
                    ->required(true)->disabled(),
            TextInput::make('slug')
                    ->label('Slug')
                    ->required(true)->disabled(),
        ];

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
