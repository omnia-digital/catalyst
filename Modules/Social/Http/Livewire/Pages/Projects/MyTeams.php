<?php

namespace Modules\Social\Http\Livewire\Pages\Teams;

use App\Models\Team;
use App\Models\User;
use App\Traits\WithSortAndFilters;
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

    public function mount()
    {
        $this->orderBy = 'name';
        
        if (!\App::environment('production')) {
            $this->useCache = false;
        }
    }

    public function getRowsQueryProperty()
    {
        $query = Team::where('user_id', auth()->id())
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

    public function render()
    {
        return view('social::livewire.pages.teams.my-teams', [
            'teams' => $this->rows,
            'teamsCount' => $this->rowsQuery->count()
        ]);
    }
}
