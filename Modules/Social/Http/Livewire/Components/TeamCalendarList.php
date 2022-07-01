<?php

namespace Modules\Social\Http\Livewire\Components;

use App\Models\Team;
use App\Models\User;
use App\Traits\WithSortAndFilters;
use Auth;
use Livewire\Component;
use OmniaDigital\OmniaLibrary\Livewire\WithCachedRows;

class TeamCalendarList extends Component
{
    use WithCachedRows, WithSortAndFilters;

    public array $sortLabels = [
        'name' => 'Name',
        'users_count' => 'Users',
        'start_date' => 'Launch Date'
    ];

    public function getRowsQueryProperty()
    {
        $query = Team::query()
            ->withCount(['users', 'media']);

        $query = $this->applyFilters($query)
            ->orderBy($this->orderBy, $this->sortOrder);

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

    public function mount()
    {
        $this->orderBy = 'name';

        if (!\App::environment('production')) {
            $this->useCache = false;
        }
    }

    public function render()
    {
        return view('social::livewire.components.team-calendar-list', [
            'teams' => $this->rows,
            'teamsCount' => $this->rowsQuery->count()
        ]);
    }
}
