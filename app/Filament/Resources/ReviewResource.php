<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewResource\Pages;
use App\Filament\Resources\ReviewResource\RelationManagers;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class ReviewResource extends Resource
{
    protected static ?string $model = \Modules\Reviews\Models\Review::class;
    protected static ?string $navigationIcon = 'heroicon-o-star';
    protected static ?string $navigationGroup = 'Social';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                      ->relationship('user', 'name'),
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
}
