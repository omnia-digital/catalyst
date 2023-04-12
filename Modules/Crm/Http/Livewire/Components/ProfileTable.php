<?php

namespace Modules\Crm\Http\Livewire\Components;

use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Modules\Social\Models\Profile;

class ProfileTable extends Component implements HasTable
{
    use InteractsWithTable;

    public function render(): \Illuminate\View\View
    {
        return view('crm::livewire.components.profile-table');
    }

    public function create()
    {
        return redirect('/admin/profiles/create');
    }

    public function isTableSearchable(): bool
    {
        return true;
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('first_name'),
            TextInput::make('last_name'),
            TextInput::make('user.email'),
            TextInput::make('user.status'),
            TextInput::make('language'),
            TextInput::make('user.current_team_id'),
            TextInput::make('user.profile_photo_path'),
            TextInput::make('user.last_active_at'),
            TextInput::make('created_at'),
            TextInput::make('updated_at'),
        ];
    }

    protected function getTableQuery()
    {
        // get all teams that I am an owner of, then get the profiles of the users on those teams
        $teams = auth()
            ->user()
            ->ownedTeams()
            ->pluck('id');
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
        return Profile::getTableColumns();
    }

    //    protected function getTableRecordUrlUsing()
    //    {
    //        return fn (Profile $record): string => route('social.profile.show', ['profile' => $record]);
    //    }

    protected function getTableFilters(): array
    {
        return [
            Filter::make('has_team')
                  ->query(function (Builder $query) {
                      // where profile has team
                      $query->whereHas('user.teams');
                  })
                  ->label('Has Team')
                  ->toggle(),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            ViewAction::make()
                      ->url(fn (Profile $record): string => route('social.profile.show', ['profile' => $record]))
                      ->openUrlInNewTab(),
            EditAction::make()
                      ->url(fn (Profile $record): string => route('social.profile.edit', ['profile' => $record]))
                      ->openUrlInNewTab(),
        ];
    }

    protected function getTableBulkActions(): array
    {
        return [
            DeleteBulkAction::make(),
        ];
    }
}
