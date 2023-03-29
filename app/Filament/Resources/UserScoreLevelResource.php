<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserScoreLevelResource\Pages;
use App\Filament\Resources\UserScoreLevelResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Modules\Social\Models\UserScoreLevel;

class UserScoreLevelResource extends Resource
{
    protected static ?string $model = UserScoreLevel::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('min_points')
                    ->label('Minimum Points')
                    ->integer()
                    ->minValue(0)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('min_points')->label('Minimum Points')
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
