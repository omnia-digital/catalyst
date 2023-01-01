<?php

namespace Modules\Crm\Http\Livewire\Components;

use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Livewire\Component;
use Modules\Social\Models\Profile;

class ProfileTable extends Component implements HasTable
{
    use InteractsWithTable;

    public function render()
    {
        return view('crm::livewire.components.profile-table');
    }

    protected function getTableQuery()
    {
        // get all teams that I am an owner of, then get the profiles of the users on those teams
        $teams = auth()->user()->ownedTeams()->pluck('id');
        // get profiles of users that have any role on any of the teams I own
        $profiles = Profile::whereHas('user', function ($query) use ($teams) {
            $query->whereHas('teams', function ($query) use ($teams) {
                $query->whereIn('team_id', $teams);
            });
        });
        return $profiles;
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('first_name'),
            TextColumn::make('last_name'),
            TextColumn::make('user.email'),
            TextColumn::make('user.status'),
            TextColumn::make('language'),
            TextColumn::make('user.current_team_id'),
            TextColumn::make('user.profile_photo_path'),
            TextColumn::make('user.last_active_at')
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
