<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FormSubmissionResource\Pages\CreateFormSubmission;
use App\Filament\Resources\FormSubmissionResource\Pages\EditFormSubmission;
use App\Filament\Resources\FormSubmissionResource\Pages\ListFormSubmissions;
use App\Filament\Resources\FormSubmissionResource\Pages\ViewFormSubmission;
use App\Models\Team;
use App\Models\User;
use Closure;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ReplicateAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Modules\Forms\Models\FormSubmission;

class FormSubmissionResource extends Resource
{
    protected static ?string $label = 'Form Submissions';
    protected static ?string $model = FormSubmission::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Forms';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('form_id')
                    ->label('Form')
                    ->options(
                        \Modules\Forms\Models\Form::get()
                            ->mapWithKeys(function ($item, $key) {
                                return [$item['id'] => $item['id'] . ' - ' . $item['name']];
                            }))
                    ->required(),
                Select::make('user_id')
                    ->label('User')
                    ->options(
                        User::get()
                            ->mapWithKeys(function ($item, $key) {
                                return [$item['id'] => $item['id'] . ' - ' . $item['name']];
                            }))
                    ->required(),
                Select::make('team_id')
                    ->label('Team')
                    ->options(
                        Team::get()
                            ->mapWithKeys(function ($item, $key) {
                                return [$item['id'] => $item['id'] . ' - ' . $item['name']];
                            }))
                    ->nullable(),
                Textarea::make('data')
                    ->hint('Please write in json format.')
                    ->columnSpan(2)
                    ->afterStateHydrated(function (TextArea $component, $state) {
                        return $component->state(json_encode($state, JSON_PRETTY_PRINT));
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('form.name'),
                TextColumn::make('user.profile.first_name')
                    ->label('First name'),
                TextColumn::make('user.profile.last_name')
                    ->label('Last name'),
                TextColumn::make('user.email')
                    ->label('Email'),
                // TextColumn::make('data')
                //     ->formatStateUsing(fn (string $state): string => json_encode($state)),
                TextColumn::make('team.name'),
                TextColumn::make('created_at')->dateTime(),
            ])
            ->filters([
                Filter::make('name'),
            ])
            ->actions([
                ViewAction::make(),
                ActionGroup::make([
                    EditAction::make(),
                    ReplicateAction::make(),
                    DeleteAction::make(),
                ]),
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
            'index' => ListFormSubmissions::route('/'),
            'create' => CreateFormSubmission::route('/create'),
            'view' => ViewFormSubmission::route('/{record}'),
            'edit' => EditFormSubmission::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getEloquentQuery()->get()->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getEloquentQuery()->get()->count() > 10 ? 'warning' : 'primary';
    }

    protected function getTableRecordUrlUsing(): Closure
    {
        return fn(Model $record): string => route('form_submissions.edit', ['record' => $record]);
    }
}
