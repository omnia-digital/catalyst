<?php

namespace Modules\Social\Http\Livewire\Components;

use App\Models\User;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Livewire\Component;
use Modules\Reviews\Models\Review;
use Ariaieboy\FilamentJalaliDatetime\JalaliDateTimeColumn;


class ReviewTable extends Component implements HasTable
{
    use InteractsWithTable;

    public function render(): \Illuminate\View\View
    {
        return view('social::livewire.components.review-table');
    }

    /**
     * @psalm-return \Illuminate\Database\Eloquent\Builder<Review>
     */
    protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return Review::query();
    }

    /**
     * @return (BooleanColumn|JalaliDateTimeColumn|TextColumn)[]
     *
     * @psalm-return array{0: TextColumn, 1: TextColumn, 2: TextColumn, 3: TextColumn, 4: TextColumn, 5: TextColumn, 6: TextColumn, 7: BooleanColumn, 8: BooleanColumn, 9: BooleanColumn, 10: JalaliDateTimeColumn, 11: TextColumn}
     */
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

    /**
     * @psalm-return array<empty, empty>
     */
    protected function getTableFilters(): array
    {
        return [
        ];
    }

    /**
     * @return (EditAction|ViewAction)[]
     *
     * @psalm-return array{0: ViewAction, 1: EditAction}
     */
    protected function getTableActions(): array
    {
        return [
            ViewAction::make(),
            EditAction::make(),
        ];
    }

    /**
     * @return DeleteBulkAction[]
     *
     * @psalm-return array{0: DeleteBulkAction}
     */
    protected function getTableBulkActions(): array
    {
        return [
            DeleteBulkAction::make(),
        ];
    }

    /**
     * @return true
     */
    public function isTableSearchable(): bool
    {
        return true;
    }
}
