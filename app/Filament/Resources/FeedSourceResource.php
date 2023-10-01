<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FeedSourceResource\Pages;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Validation\Rule;
use Modules\Feeds\Enums\FeedSourceType;
use Modules\Feeds\Models\FeedSource;

class FeedSourceResource extends Resource
{
    protected static ?string $model = FeedSource::class;

    protected static ?string $navigationIcon = 'heroicon-o-rss';

    protected static ?string $navigationGroup = 'Feeds';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),

                Forms\Components\TextInput::make('url')
                    ->label('URL')
                    ->required()
                    ->rules(['url']),

                Forms\Components\Select::make('type')
                    ->options(FeedSourceType::options())
                    ->required()
                    ->rules([Rule::in(array_keys(FeedSourceType::options()))]),

                Forms\Components\SpatieMediaLibraryFileUpload::make('default_feed_image'),
                Forms\Components\SpatieMediaLibraryFileUpload::make('default_item_image'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('url')
                    ->searchable()
                    ->copyable(),

                Tables\Columns\SelectColumn::make('type')
                    ->options(FeedSourceType::options())
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFeedSources::route('/'),
            'create' => Pages\CreateFeedSource::route('/create'),
            'edit' => Pages\EditFeedSource::route('/{record}/edit'),
        ];
    }
}
