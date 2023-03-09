<?php

namespace Modules\Social\Http\Livewire\Pages\Profiles;

use App\Models\Team;
use App\Traits\Filter\WithSortAndFilters;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Social\Models\Profile;
use OmniaDigital\OmniaLibrary\Livewire\WithCachedRows;

class Teams extends Component
{
    use WithPagination, WithCachedRows, WithSortAndFilters;

    public array $sortLabels = [
        'name' => 'Name',
        'users_count' => 'Users',
        'start_date' => 'Launch Date'
    ];

    public string $dateColumn = 'start_date';

    public $profile;
        
    public function getUserProperty()
    {
        return $this->profile->user;
    }

    public function mount(Profile $profile)
    {
        $this->profile = $profile->load('user');

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
            
        $query = $query->when($this->search, fn(Builder $q) => $q->search($this->search));
        $query = $this->applySorting($query);

        return $query;
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->rowsQuery->paginate(100);
        });
    }

    public function render()
    {
        return view('social::livewire.pages.profiles.teams', [
            'teams' => $this->rows,
            'teamsCount' => $this->rowsQuery->count()
        ]);
    }
}
