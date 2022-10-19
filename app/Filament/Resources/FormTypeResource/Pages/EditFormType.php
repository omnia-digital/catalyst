<?php

namespace App\Filament\Resources\FormTypeResource\Pages;

use App\Filament\Resources\FormResource;
use App\Filament\Resources\FormTypeResource;
use Filament\Forms\Components\BelongsToManyMultiSelect;
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

class EditFormType extends EditRecord implements HasForms
{
    //    use InteractsWithForms;

    protected static string $resource = FormTypeResource::class;

    protected function getFormSchema(): array
    {
        $fields = [
            TextInput::make('name')
                     ->label('Name')
                     ->required(true),
            TextInput::make('slug')
                     ->label('Slug')
                     ->required(true)
                     ->hint('Do not change this if this form has been sent to users because it is used in the form link, so any previous links sent will be broken.'),
        ];

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
