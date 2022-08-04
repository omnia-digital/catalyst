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

    public function render()
    {
        return view('social::livewire.components.user-table');
    }

    protected function getTableQuery()
    {
        return User::query()->where;
    }

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

    public function isTableSearchable(): bool
    {
        return true;
    }
}
