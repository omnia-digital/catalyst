<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserScoreLevelResource\Pages;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\Social\Models\UserScoreLevel;

class UserScoreLevelResource extends Resource
{
    protected static ?string $model = UserScoreLevel::class;
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('level')
                    ->integer()
                    ->minValue(0)
                    ->required(),
                TextInput::make('min_points')
                    ->label('Minimum Points')
                    ->integer()
                    ->minValue(0)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('level'),
                TextColumn::make('min_points')->label('Minimum Points'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListUserScoreLevels::route('/'),
            'create' => Pages\CreateUserScoreLevel::route('/create'),
            'edit' => Pages\EditUserScoreLevel::route('/{record}/edit'),
        ];
    }
}
