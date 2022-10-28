<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FormTypeResource\Pages\CreateFormType;
use App\Filament\Resources\FormTypeResource\Pages\EditFormType;
use App\Filament\Resources\FormTypeResource\Pages\ListFormsType;
use App\Filament\Resources\FormTypeResource\Pages\ViewFormType;
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

class FormTypeResource extends Resource
{
    protected static ?string $label = 'Form Types';
    protected static ?string $model = \Modules\Forms\Models\FormType::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Forms';
    public $data = [];

    protected static function getNavigationBadge(): ?string
    {
        return static::getEloquentQuery()->get()->count();
    }

    protected static function getNavigationBadgeColor(): ?string
    {
        return static::getEloquentQuery()->get()->count() > 10 ? 'warning' : 'primary';
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
            'index' => ListFormsType::route('/'),
            'create' => CreateFormType::route('/create'),
            'view' => ViewFormType::route('/{record}'),
            'edit' => EditFormType::route('/{record}/edit'),
        ];
    }

    protected function getTableRecordUrlUsing(): Closure
    {
        return fn (Model $record): string => route('form_types.edit', ['record' => $record]);
    }
}
