<?php

namespace Modules\Advice\Http\Livewire\Pages\Questions;

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
        'search'
    ];

    public function mount(): void
    {
        if (!\App::environment('production')) {
            $this->useCache = false;
        }
    }

    public function updatedFilters(): void
    {
        $this->resetPage();
    }

    public function getRowsQueryProperty()
    {
        $query = clone $this->rowsQueryWithoutFilters;

        return $query;
    }

    /**
     * @psalm-return \Illuminate\Database\Eloquent\Builder<Post&\Illuminate\Database\Eloquent\Builder<Post>>
     */
    public function getRowsQueryWithoutFiltersProperty(): \Illuminate\Database\Eloquent\Builder
    {
        return Post::where('type','=','question')->orderByDesc('updated_at');
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->rowsQuery->paginate(100);
        });
    }

    public function render(): \Illuminate\View\View
    {
        return view('advice::livewire.pages.questions.index', [
            'questions' => $this->rows
        ]);
    }
}
