<?php

namespace Modules\Social\Http\Livewire\Pages\Projects;

use App\Models\Team;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use OmniaDigital\OmniaLibrary\Livewire\WithCachedRows;

class MyProjects extends Component
{
    use WithPagination, WithCachedRows;

    public array $filters = [
        'created_at' => '',
        'has_attachment' => false,
    ];

    public array $sortLabels = [
        'name' => 'Name', 
        'users_count' => 'Users', 
        'start_date' => 'Launch Date'
    ];

    public string $orderBy = 'name';
    public bool $sortDesc = true;

    public function mount()
    {
        if (!\App::environment('production')) {
            $this->useCache = false;
        }
    }

    public function updatedFilters()
    {
        $this->resetPage();
    }

    public function sortBy($key)
    {
        if($this->orderBy === $key) {
            $this->sortDesc = !$this->sortDesc;
        } else {
            $this->orderBy = $key;
            $this->sertDesc = true;
        }
    }

    public function getRowsQueryProperty()
    {
        return 
            Team::where('user_id', auth()->id())
                ->withCount('users')
                ->orderBy($this->orderBy, $this->sortDesc ? 'desc' : 'asc');
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
            'projects' => $this->rows
        ]);
    }
}
