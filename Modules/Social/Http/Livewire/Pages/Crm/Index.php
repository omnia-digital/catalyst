<?php

namespace Modules\Social\Http\Livewire\Pages\Crm;

use App\Models\User;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class Index extends Component implements HasTable
{
    use InteractsWithTable;

    public function render()
    {
        return view('social::livewire.pages.crm.index');
    }

    protected function getTableQuery()
    {
        return User::query();
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('profile_id'),
            TextColumn::make('first_name'),
            TextColumn::make('last_name'),
            TextColumn::make('email'),
            TextColumn::make('email_verified_at')
                      ->dateTime(),
            TextColumn::make('two_factor_secret'),
            TextColumn::make('two_factor_recovery_codes'),
            TextColumn::make('status'),
            BooleanColumn::make('2fa_enabled'),
            TextColumn::make('2fa_secret'),
            TextColumn::make('2fa_backup_codes'),
            TextColumn::make('2fa_setup_at')
                      ->dateTime(),
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
