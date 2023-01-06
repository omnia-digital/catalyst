<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProfileResource\RelationManagers;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Modules\Games\Models\Game;
use RalphJSmit\Filament\Components\Forms\Timestamps;

class GameResource extends Resource
{
    protected static ?string $model = Game::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Games';
    protected $queryString = [
        'tableColumnSearchQueries'
    ];

    protected static function shouldRegisterNavigation(): bool
    {
        return \Platform::isModuleEnabled('games') ? true : false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('igdb_id'),
                Forms\Components\TextInput::make('name'),
                Forms\Components\TextInput::make('slug'),
                Timestamps::make(),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('igdb_id')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('slug')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('updated_at')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('deleted_at')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }



    public static function getPages(): array
    {
        return [
            'index' => GameResource\Pages\ManageGames::route('/'),
            'create' => GameResource\Pages\CreateGame::route('/create'),
            'edit' => GameResource\Pages\EditGames::route('/edit/{record}'),
        ];
    }
}
