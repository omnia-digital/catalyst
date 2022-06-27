<?php

namespace Modules\Social\Http\Livewire\Pages\Projects;

use App\Models\Team;
use App\Models\User;
use App\Traits\WithSortAndFilters;
use Livewire\Component;
use Livewire\WithPagination;
use OmniaDigital\OmniaLibrary\Livewire\WithCachedRows;

class MyProjects extends Component
{
    use WithPagination, WithCachedRows, WithSortAndFilters;

    public array $filters = [
        'start_date' => '',
        'created_at' => '',
        'has_attachment' => false,
    ];

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
        return 
            Team::where('user_id', auth()->id())
                ->withCount('users')
                ->orderBy($this->orderBy, $this->sortOrder);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->rowsQuery->paginate(100);
        });
    }

    public function render()
    {
        return view('social::livewire.pages.projects.my-projects', [
            'projects' => $this->rows,
            'projectsCount' => $this->rowsQuery->count()
        ]);
    }
}
