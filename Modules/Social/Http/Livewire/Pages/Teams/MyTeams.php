<?php

namespace Modules\Social\Http\Livewire\Pages\Teams;

use App\Models\Team;
use App\Models\User;
use App\Support\Platform\Platform;
use App\Support\Platform\WithGuestAccess;
use App\Traits\Filter\WithSortAndFilters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use OmniaDigital\OmniaLibrary\Livewire\WithCachedRows;

class MyTeams extends Component
{
    use WithPagination, WithCachedRows, WithSortAndFilters, WithGuestAccess;

    public array $sortLabels = [
        'name' => 'Name',
        'users_count' => 'Users',
        'start_date' => 'Launch Date'
    ];

    public string $dateColumn = 'start_date';

    public function mount()
    {
        if (Platform::isAllowingGuestAccess() && !Auth::check()) {
            $this->redirectToAuthenticationPage();

            return;
        }

        $this->orderBy = 'name';

        if (!\App::environment('production')) {
            $this->useCache = false;
        }
    }

    public function getRowsQueryProperty()
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

    public function getUserProperty()
    {
        return User::find(Auth::id());
    }

    public function render()
    {
        return view('social::livewire.pages.teams.my-teams', [
            'teams' => $this->rows,
            'teamsCount' => $this->rowsQuery->count()
        ]);
    }
}
