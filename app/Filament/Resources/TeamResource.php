<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeamResource\Pages;
use App\Filament\Resources\TeamResource\RelationManagers;
use App\Models\Team;
use App\Models\User;
use Ariaieboy\FilamentJalaliDatetime\JalaliDateTimeColumn;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TeamResource extends Resource
{
    protected static ?string $label = 'Teams';
    protected static ?string $model = Team::class;
    protected static ?string $navigationIcon = 'heroicon-o-globe';
    protected static ?string $navigationGroup = 'Social';

    public static function getGloballySearchableAttributes(): array
    {
        return ['name'];
    }

//    public static function getEloquentQuery(): Builder
//    {
//        if (auth()->user()->is_admin) {
//            return parent::getEloquentQuery();
//        } else {
//            return parent::getEloquentQuery()->whereIn('id', auth()->user()->ownedTeams->pluck('id'));
//        }
//    }

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
//                Forms\Components\Select::make('user_id')
//                    ->label('Owner')
//                    ->options(User::all()
//                        ->mapWithKeys(function ($item, $key) {
//                            return [$item['id'] => $item['id'] . ' - ' . $item['name']];
//                        }))
//                    ->searchable()
//                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('start_date'),

                Forms\Components\Textarea::make('summary')
                    ->maxLength(65535),
                Forms\Components\Textarea::make('content')
                    ->maxLength(65535)
                    ->required(),
                Forms\Components\TextInput::make('location')
                    ->maxLength(255),
                Forms\Components\TextInput::make('rating'),
                Forms\Components\TextInput::make('languages')
                    ->required()
                    ->maxLength(255),
//                Forms\Components\MultiSelect::make('teamTags')
//                    ->label('Team Tags')
//                    ->relationship('teamTags', 'name')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('owner.name')
                    ->label('Owner'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('start_date')
                                         ->date(config('app.default_date_format')),
//                Tables\Columns\TextColumn::make('summary'),
//                Tables\Columns\TextColumn::make('content'),
//                Tables\Columns\TextColumn::make('location'),
//                Tables\Columns\TextColumn::make('rating'),
//                Tables\Columns\TextColumn::make('languages'),
//                Tables\Columns\TextColumn::make('created_at')
//                    ->dateTime(),
//                Tables\Columns\TextColumn::make('updated_at')
//                    ->dateTime(),
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
            RelationManagers\TeamTypesRelationManager::class,
            RelationManagers\TeamTagsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTeams::route('/'),
            'create' => Pages\CreateTeam::route('/create'),
            'view' => Pages\ViewTeam::route('/{record}'),
            'edit' => Pages\EditTeam::route('/{record}/edit'),
        ];
    }
}
