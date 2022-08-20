<?php

namespace Modules\Social\Http\Livewire\Components;

use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Modules\Crm\Models\Contact;
use Modules\Social\Models\Profile;

class ProfileTable extends Component implements HasTable
{
    use InteractsWithTable;

    public function render(): \Illuminate\View\View
    {
        return view('social::livewire.components.profile-table');
    }

    /**
     * @psalm-return Builder<Profile>
     */
    protected function getTableQuery(): Builder
    {
//        if (auth()->user()->is_admin) {
            return Profile::query();
//        }
//        else {
//            return Contact::query()->whereHas('user', fn(Builder $query) => $query->whereIn('teams.id', auth()->user()->ownedTeams->pluck('id')));
//        }

    }

    /**
     * @return TextColumn[]
     *
     * @psalm-return array{0: TextColumn, 1: TextColumn, 2: TextColumn, 3: TextColumn, 4: TextColumn, 5: TextColumn, 6: TextColumn, 7: TextColumn, 8: TextColumn, 9: TextColumn}
     */
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
