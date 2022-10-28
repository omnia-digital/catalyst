<?php

namespace App\Filament\Resources\FormSubmissionResource\Pages;

use App\Filament\Resources\FormSubmissionResource;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;
use Modules\Forms\Models\Form;

class CreateFormSubmission extends CreateRecord implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = FormSubmissionResource::class;

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('name')
                ->label('Name')
                ->reactive()
                ->required(),
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
}
