<?php

namespace Modules\Social\Http\Livewire\Partials;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Social\Models\Post;
use OmniaDigital\OmniaLibrary\Livewire\WithCachedRows;

class TrendingSection extends Component
{
    use WithPagination, WithCachedRows;

    public $title = 'Trending';

    public $type;

    public function mount($type = null)
    {
        if (!\App::environment('production')) {
            $this->useCache = false;
        }

        if (!empty($type)) {
            $this->type = $type;
        }
    }

    public function getRowsQueryProperty()
    {
        return Post::with('user')
            ->when($this->type, fn($query) => $query->where('type', $this->type));
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->rowsQuery->paginate(5);
        });
    }

    public function render()
    {
        return view('social::livewire.partials.trending-section', [
            'posts' => $this->rows
        ]);
    }
}
