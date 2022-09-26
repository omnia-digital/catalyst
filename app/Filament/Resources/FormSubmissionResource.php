<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FormSubmissionResource\Pages\CreateFormSubmission;
use App\Filament\Resources\FormSubmissionResource\Pages\EditFormSubmission;
use App\Filament\Resources\FormSubmissionResource\Pages\ListFormSubmissions;
use App\Filament\Resources\FormSubmissionResource\Pages\ViewFormSubmission;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ReplicateAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;

class FormSubmissionResource extends Resource
{
    protected static ?string $label = 'Form Submissions';
    protected static ?string $model = \Modules\Forms\Models\FormSubmission::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Settings';

    protected static function getNavigationBadge(): ?string
    {
        return static::getEloquentQuery()->get()->count();
    }

    protected static function getNavigationBadgeColor(): ?string
    {
        return static::getEloquentQuery()->get()->count() > 10 ? 'warning' : 'primary';
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
//                TextColumn::make('data'),
                TextColumn::make('user.profile.first_name'),
                TextColumn::make('user.profile.last_name'),
                TextColumn::make('user.email'),
                TextColumn::make('form.name'),
                TextColumn::make('team.name'),
            ])
            ->filters([
                Filter::make('name')
            ])
            ->actions([
                ViewAction::make(),
                ActionGroup::make([
                    EditAction::make(),
                    ReplicateAction::make(),
                    DeleteAction::make(),
                ])
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
//            'create' => CreateFormSubmission::route('/create'),
            'view' => ViewFormSubmission::route('/{record}'),
            'edit' => EditFormSubmission::route('/{record}/edit'),
        ];
    }

    protected function getTableRecordUrlUsing(): Closure
    {
        return fn (Model $record): string => route('form_submissions.edit', ['record' => $record]);
    }
}
