<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\MultiSelect;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $label = 'Members';
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationGroup = 'My Teams';

    public static function getEloquentQuery(): Builder
    {
        if (auth()->user()->is_admin) {
            return User::query();
        } else {
            return parent::getEloquentQuery()->whereHas('teams', fn(Builder $query) => $query->whereIn('teams.id', auth()->user()->ownedTeams->pluck('id')));
        }
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
                TextInput::make('profile_id'),
                TextInput::make('first_name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('last_name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->password()
                    ->required()
                    ->maxLength(255),
                Textarea::make('two_factor_secret')
                    ->maxLength(65535),
                Textarea::make('two_factor_recovery_codes')
                    ->maxLength(65535),
                TextInput::make('status')
                    ->maxLength(255),
                Toggle::make('2fa_enabled')
                    ->required(),
                TextInput::make('2fa_secret')
                    ->maxLength(255),
                TextInput::make('2fa_backup_codes'),
                DateTimePicker::make('2fa_setup_at'),
                TextInput::make('language')
                    ->maxLength(255),
                TextInput::make('current_team_id'),
                TextInput::make('profile_photo_path')
                    ->maxLength(2048),
                DateTimePicker::make('last_active_at'),
                DateTimePicker::make('delete_after'),
                MultiSelect::make('teams')->relationship('teams', 'name'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('profile.id'),
                TextColumn::make('profile.first_name'),
                TextColumn::make('profile.last_name'),
                TextColumn::make('email'),
                TextColumn::make('email_verified_at')
                    ->dateTime(config('app.default_datetime_format')),
//                TextColumn::make('two_factor_secret'),
//                TextColumn::make('two_factor_recovery_codes'),
                TextColumn::make('status'),
//                Tables\Columns\BooleanColumn::make('2fa_enabled'),
//                TextColumn::make('2fa_secret'),
//                TextColumn::make('2fa_backup_codes'),
//                TextColumn::make('2fa_setup_at')
//                    ->dateTime(),
//                TextColumn::make('language'),
                TextColumn::make('current_team.name'),
//                TextColumn::make('profile_photo_path'),
                TextColumn::make('last_active_at')
                    ->dateTime(config('app.default_datetime_format')),
//                TextColumn::make('delete_after')
//                    ->dateTime(),
//                TextColumn::make('deleted_at')
//                    ->dateTime(),
                TextColumn::make('created_at')
                    ->dateTime(config('app.default_datetime_format')),
//                TextColumn::make('updated_at')
//                    ->dateTime(),

            ])
            ->filters([

            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    protected function getTableRecordUrlUsing(): Closure
    {
        return fn (Model $record): string => route('users.edit', ['record' => $record]);
    }
}
