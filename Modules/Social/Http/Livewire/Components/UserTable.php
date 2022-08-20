<?php

namespace Modules\Social\Http\Livewire\Components;

use App\Models\User;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Livewire\Component;

class UserTable extends Component implements HasTable
{
    use InteractsWithTable;

    public function render(): \Illuminate\View\View
    {
        return view('social::livewire.components.user-table');
    }

    protected function getTableQuery()
    {
        return User::query()->where;
    }

    /**
     * @return TextColumn[]
     *
     * @psalm-return array{0: TextColumn, 1: TextColumn, 2: TextColumn, 3: TextColumn, 4: TextColumn, 5: TextColumn, 6: TextColumn, 7: TextColumn, 8: TextColumn, 9: TextColumn, 10: TextColumn, 11: TextColumn}
     */
    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('profile.first_name'),
            TextColumn::make('profile.last_name'),
            TextColumn::make('email'),
            TextColumn::make('status'),
            TextColumn::make('language'),
            TextColumn::make('current_team_id'),
            TextColumn::make('profile_photo_path'),
            TextColumn::make('last_active_at')
                      ->dateTime(),
            TextColumn::make('delete_after')
                      ->dateTime(),
            TextColumn::make('deleted_at')
                      ->dateTime(),
            TextColumn::make('created_at')
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
