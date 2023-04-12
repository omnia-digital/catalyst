<?php

namespace Modules\Advice\Http\Livewire\Pages\Questions;

use Illuminate\Support\Facades\App;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Social\Models\Post;
use OmniaDigital\OmniaLibrary\Livewire\WithCachedRows;

use function view;

class Index extends Component
{
    use WithPagination, WithCachedRows;

    public ?string $search = null;

    public array $filters = [
        'date_created' => '',
        'has_attachment' => false,
    ];

    public string $orderBy = 'date_created';

    protected $queryString = [
        'search',
    ];

    public function mount()
    {
        if (! App::environment('production')) {
            $this->useCache = false;
        }
    }

    public function updatedFilters()
    {
        $this->resetPage();
    }

    public function getRowsQueryProperty()
    {
        $query = clone $this->rowsQueryWithoutFilters;

        return $query;
    }

    public function getRowsQueryWithoutFiltersProperty()
    {
        return Post::where('type', '=', 'question')->orderByDesc('updated_at');
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->rowsQuery->paginate(100);
        });
    }

    public function render()
    {
        return view('advice::livewire.pages.questions.index', [
            'questions' => $this->rows,
        ]);
    }
}
