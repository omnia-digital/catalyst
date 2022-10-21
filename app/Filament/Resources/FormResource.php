<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FormResource\Pages\CreateForm;
use App\Filament\Resources\FormResource\Pages\EditForm;
use App\Filament\Resources\FormResource\Pages\EditFormType;
use App\Filament\Resources\FormResource\Pages\ListForms;
use App\Filament\Resources\FormResource\Pages\ListFormsType;
use App\Filament\Resources\FormResource\Pages\ViewForm;
use App\Filament\Resources\FormResource\Pages\ViewFormType;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ReplicateAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Forms;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Illuminate\Support\Str;
use Modules\Forms\Models\FormType;

class FormResource extends Resource
{
    protected static ?string $label = 'Forms';
    protected static ?string $model = \Modules\Forms\Models\Form::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Forms';
    //public $data = [];

    protected static function getNavigationBadge(): ?string
    {
        return static::getEloquentQuery()->get()->count();
    }

    protected static function getNavigationBadgeColor(): ?string
    {
        return static::getEloquentQuery()->get()->count() > 10 ? 'warning' : 'primary';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Name')
                    ->required(true),
                Select::make('form_type_id')
                    ->label('Form Type')
                    ->options(FormType::pluck('name', 'id')->toArray()),
                TextInput::make('slug')
                    ->label('Slug')
                    ->required(true)
                    ->hint('Do not change this if this form has been sent to users because it is used in the form link, so any previous links sent will be broken.')
                    ->columnSpan(2),
                Builder::make('content')
                    ->columnSpan(2)
                    ->blocks([
                        Block::make('text')
                             ->label('Text input')
                             ->icon('heroicon-o-annotation')
                             ->schema([
                                 self::getFieldNameInput(),
                                 Checkbox::make('is_required'),
                             ]),
                        Block::make('select')
                             ->icon('heroicon-o-selector')
                             ->schema([
                                 self::getFieldNameInput(),
                                 KeyValue::make('options')
                                         ->addButtonLabel('Add option')
                                         ->keyLabel('Value')
                                         ->valueLabel('Label'),
                                 Checkbox::make('is_required'),
                             ]),
                        Block::make('checkbox')
                             ->icon('heroicon-o-check-circle')
                             ->schema([
                                 self::getFieldNameInput(),
                                 Checkbox::make('is_required'),
                             ]),
                        Block::make('file')
                             ->icon('heroicon-o-photograph')
                             ->schema([
                                 self::getFieldNameInput(),
                                 Grid::make()
                                     ->schema([
                                         Checkbox::make('is_multiple'),
                                         Checkbox::make('is_required'),
                                     ]),
                             ]),
                    ])
                    ->createItemButtonLabel('Add form input')
                    ->disableLabel()
            ]);
    }

    protected static function getFieldNameInput(): Grid
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
            ])
            ->filters([
                Filter::make('name')
            ])
            ->actions([
                ViewAction::make(),
                ActionGroup::make([
                    EditAction::make(),
                    ReplicateAction::make(),
                    DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListForms::route('/'),
            'create' => CreateForm::route('/create'),
            'view' => ViewForm::route('/{record}'),
            'edit' => EditForm::route('/{record}/edit'),
        ];
    }

    protected function getTableRecordUrlUsing(): Closure
    {
        return fn (Model $record): string => route('forms.edit', ['record' => $record]);
    }
}
