<?php

namespace Modules\Crm\Http\Livewire\Components;

use Ariaieboy\FilamentJalaliDatetime\JalaliDateTimeColumn;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Livewire\Component;
use Modules\Reviews\Models\Review;

class ReviewTable extends Component implements HasTable
{
    use InteractsWithTable;

    public function render()
    {
        return view('crm::livewire.components.review-table');
    }

    public function isTableSearchable(): bool
    {
        return true;
    }

    protected function getTableQuery()
    {
        return Review::query();
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('id'),
            TextColumn::make('user_id'),
            TextColumn::make('reviewable_type'),
            TextColumn::make('reviewable_id'),
            TextColumn::make('body'),
            TextColumn::make('visibility'),
            TextColumn::make('language_id'),
            BooleanColumn::make('received_product_free'),
            BooleanColumn::make('recommend'),
            BooleanColumn::make('commentable'),
            JalaliDateTimeColumn::make('created_at')
                      ->dateTime(),
            TextColumn::make('updated_at')
                      ->dateTime(),
        ];
    }

    protected function getTableFilters(): array
    {
        return [
        ];
    }

    protected function getTableActions(): array
    {
        return [
            ViewAction::make(),
            EditAction::make(),
        ];
    }

    protected function getTableBulkActions(): array
    {
        return [
            DeleteBulkAction::make(),
        ];
    }
}
