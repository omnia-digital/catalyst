<?php

namespace Modules\Social\Http\Livewire\Pages\Teams;

use App\Models\Team;
use App\Models\User;
use App\Traits\Filter\WithSortAndFilters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use OmniaDigital\OmniaLibrary\Livewire\WithCachedRows;

class MyTeams extends Component
{
    use WithPagination, WithCachedRows, WithSortAndFilters;

    public array $sortLabels = [
        'name' => 'Name',
        'users_count' => 'Users',
        'start_date' => 'Launch Date'
    ];

    public string $dateColumn = 'start_date';

    public function mount(): void
    {
        $this->orderBy = 'name';

        if (!\App::environment('production')) {
            $this->useCache = false;
        }
    }

    /**
     * @psalm-return Builder<\Illuminate\Database\Eloquent\Model>
     */
    public function getRowsQueryProperty(): Builder
    {
        $query = Team::query()
            ->withUser($this->user)
            ->withCount(['users']);
            
        $query = $this->applyFilters($query)
            ->when($this->search, fn(Builder $q) => $q->search($this->search));
        $query = $this->applySorting($query);

        return $query;
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->rowsQuery->paginate(100);
        });
    }

    public function getUserProperty(): User|null
    {
        return User::find(Auth::id());
    }

    public function render(): \Illuminate\View\View
    {
        return view('social::livewire.pages.teams.my-teams', [
            'teams' => $this->rows,
            'teamsCount' => $this->rowsQuery->count()
        ]);
    }
}
