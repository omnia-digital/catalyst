<?php

namespace Modules\Social\Http\Livewire\Partials;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Social\Models\Like;
use Modules\Social\Models\Post;
use OmniaDigital\OmniaLibrary\Livewire\WithCachedRows;
use Illuminate\Support\Facades\App;

class TrendingSection extends Component
{
    use WithPagination, WithCachedRows;

    public $title = 'Trending';

    public $type;

    public function mount($type = null)
    {
        if (!App::environment('production')) {
            $this->useCache = false;
        }

        if (!empty($type)) {
            $this->type = $type;
        }
    }

    public function showProfile($url) {
        return $this->redirect($url);
    }

    public function getRowsQueryProperty()
    {
        return Post::getTrending($this->type);
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
