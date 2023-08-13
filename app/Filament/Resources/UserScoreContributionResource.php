<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserScoreContributionResource\Pages;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Modules\Social\Models\UserScoreContribution;

class UserScoreContributionResource extends Resource
{
    protected static ?string $model = UserScoreContribution::class;
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->required()
                ->maxLength(255),
            TextInput::make('slug')
                ->required(),
            TextInput::make('points')
                ->integer()
                ->minValue(0)
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name'),
            TextColumn::make('slug'),
            TextColumn::make('points'),
        ])
            ->filters([//
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
        return [//
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUserScoreContributions::route('/'),
            'create' => Pages\CreateUserScoreContribution::route('/create'),
            'edit' => Pages\EditUserScoreContribution::route('/{record}/edit'),
        ];
    }
}
