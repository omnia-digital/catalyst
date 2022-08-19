<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeamTypeResource\Pages;
use App\Filament\Resources\TeamTypeResource\RelationManagers;
use Ariaieboy\FilamentJalaliDatetime\JalaliDateTimeColumn;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Tags\Tag;

class TeamTypeResource extends Resource
{
    protected static ?string $label = 'Team Types';
    protected static ?string $model = Tag::class;
    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationGroup = 'Settings';

    public static function registerNavigationItems(): void
    {
        if (auth()->user()->is_admin) {
            parent::registerNavigationItems();
        }
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('type', 'team_type');
    }

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
                Forms\Components\KeyValue::make('name')
                    ->keyLabel('Language Code')
                    ->valueLabel('Name')
                    ->required(),
                Forms\Components\KeyValue::make('slug')
                     ->keyLabel('Language Code')
                     ->valueLabel('Name')
                    ->required(),
                Forms\Components\TextInput::make('type')
                  ->required()
                  ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable(),
                Tables\Columns\TextColumn::make('slug')->sortable(),
                Tables\Columns\TextColumn::make('type')->sortable(),
                JalaliDateTimeColumn::make('created_at')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make('view'),
                Tables\Actions\EditAction::make('edit'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTeamTypes::route('/'),
            'create' => Pages\CreateTeamType::route('/create'),
            'view' => Pages\ViewTeamType::route('/{record}'),
            'edit' => Pages\EditTeamType::route('/{record}/edit'),
        ];
    }
}
