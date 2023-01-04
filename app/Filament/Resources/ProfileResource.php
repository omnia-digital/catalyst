<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProfileResource\Pages;
use App\Filament\Resources\ProfileResource\RelationManagers;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Modules\Social\Models\Profile;

class ProfileResource extends Resource
{
    protected static ?string $label = 'Profiles';
    protected static ?string $model = Profile::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Social';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('first_name'),
                Forms\Components\TextInput::make('last_name'),
                Forms\Components\TextInput::make('user.email'),
                Forms\Components\TextInput::make('user.status'),
                Forms\Components\TextInput::make('language'),
                Forms\Components\TextInput::make('user.current_team_id'),
                Forms\Components\TextInput::make('user.profile_photo_path'),
                Forms\Components\TextInput::make('user.last_active_at'),
                Forms\Components\TextInput::make('created_at'),
                Forms\Components\TextInput::make('updated_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(Profile::getTableColumns())
            ->filters([
                Filter::make('has_team')->query(function (Builder $query) {
                    // where profile has team
                    $query->whereHas('user.teams');
                })->label('Has Team')->toggle(),
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
            'index' => Pages\ManageProfiles::route('/'),
            'create' => Pages\CreateProfile::route('/create'),
            'edit' => Pages\EditProfile::route('/edit/{record}'),
        ];
    }
}
