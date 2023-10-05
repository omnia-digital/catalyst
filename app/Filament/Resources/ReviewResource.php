<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewResource\Pages;
use App\Filament\Resources\ReviewResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Modules\Reviews\Models\Review;
use OmniaDigital\CatalystCore\Facades\Translate;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;
    protected static ?string $navigationIcon = 'heroicon-o-star';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship(name: 'user')
                    ->getOptionLabelFromRecordUsing(fn (User $record) => $record->name)
                    ->searchable(['first_name', 'last_name']),
                Forms\Components\TextInput::make('reviewable_type')
                    ->required(),
                Forms\Components\TextInput::make('reviewable_id')
                    ->required(),
                Forms\Components\Textarea::make('body'),
                Forms\Components\TextInput::make('language_id'),
                Forms\Components\Checkbox::make('visibility'),
                Forms\Components\Checkbox::make('received_product_free'),
                Forms\Components\Checkbox::make('recommend'),
                Forms\Components\Checkbox::make('commentable'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('reviewable_type'),
                Tables\Columns\TextColumn::make('reviewable_id'),
                Tables\Columns\TextColumn::make('body'),
                Tables\Columns\TextColumn::make('language_id'),
                Tables\Columns\BooleanColumn::make('visibility'),
                Tables\Columns\BooleanColumn::make('received_product_free'),
                Tables\Columns\BooleanColumn::make('recommend'),
                Tables\Columns\BooleanColumn::make('commentable'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ReviewsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReviews::route('/'),
            'create' => Pages\CreateReview::route('/create'),
            'view' => Pages\ViewReview::route('/{record}'),
            'edit' => Pages\EditReview::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return Translate::get('Teams');
    }
}
