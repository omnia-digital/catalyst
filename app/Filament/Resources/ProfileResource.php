<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProfileResource\Pages\CreateProfile;
use App\Filament\Resources\ProfileResource\Pages\EditProfile;
use App\Filament\Resources\ProfileResource\Pages\ManageProfiles;
use App\Filament\Resources\ProfileResource\RelationManagers;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Modules\Social\Models\Profile;
use RalphJSmit\Filament\Components\Forms\CreatedAt;
use RalphJSmit\Filament\Components\Forms\DeletedAt;
use RalphJSmit\Filament\Components\Forms\Timestamp;
use RalphJSmit\Filament\Components\Forms\UpdatedAt;

class ProfileResource extends Resource
{
    protected static ?string $model = Profile::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Social';
    protected $queryString = [
        'tableColumnSearchQueries'
    ];

    public static function getLabel(): ?string
    {
        return 'Contact';
    }

    protected static function getNavigationLabel(): string
    {
        if (auth()->user()->is_admin) {
            return 'Contacts (Profiles)';
        } else {
            return 'Contacts';
        }
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('first_name'),
                Forms\Components\TextInput::make('last_name'),
                Forms\Components\Fieldset::make('User')
                        ->relationship('user')->visibleOn('edit')
                        ->schema([
                            Forms\Components\Grid::make(12)->schema([
                                Forms\Components\TextInput::make('id')->disabled()->columnSpan(3),
                                Forms\Components\Toggle::make('is_admin')->disabled(auth()->user()->is_admin)->columnSpan(3),
                                Forms\Components\TextInput::make('email')->columnSpan(6),
                            ]),
                            Timestamp::make('last_active_at'),
                            Forms\Components\Select::make('current_team_id')->relationship('currentTeam','name'),
                        ]),
                CreatedAt::make()->visibleOn('edit'),
                UpdatedAt::make()->visibleOn('edit'),
                DeletedAt::make()->visibleOn('edit'),
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
                })->label(\Trans::get('Has Team'))->toggle(),
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
            'index' => ManageProfiles::route('/'),
            'create' => CreateProfile::route('/create'),
            'edit' => EditProfile::route('/edit/{record}'),
        ];
    }
}
