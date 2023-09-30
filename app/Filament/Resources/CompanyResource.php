<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyResource\Pages\CreateCompany;
use App\Filament\Resources\CompanyResource\Pages\EditCompany;
use App\Filament\Resources\CompanyResource\Pages\ManageCompanies;
use App\Models\Company;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use RalphJSmit\Filament\Components\Forms\Timestamps;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'People';

//    protected $queryString = [
//        'tableColumnSearchQueries',
//    ];

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('id'),
            Forms\Components\TextInput::make('name'),
            Forms\Components\TextInput::make('email'),
            Forms\Components\TextInput::make('website'),
            Forms\Components\TextInput::make('about'),
            ...Timestamps::make(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('id')
                ->sortable()
                ->searchable(),
            TextColumn::make('name')
                ->sortable()
                ->searchable(),
            TextColumn::make('email')
                ->sortable()
                ->searchable(),
            TextColumn::make('website')
                ->sortable()
                ->searchable(),
            TextColumn::make('about')
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
            ->filters([])
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
            'index' => ManageCompanies::route('/'),
            'create' => CreateCompany::route('/create'),
            'edit' => EditCompany::route('/edit/{record}'),
        ];
    }
}
