<?php

namespace Modules\Resources\Http\Livewire\Pages;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Social\Models\Post;
use OmniaDigital\OmniaLibrary\Livewire\WithCachedRows;

class Home extends Component
{
    use WithPagination, WithCachedRows;

    public function getRowsQueryProperty()
    {
        $query = clone $this->rowsQueryWithoutFilters;

        return $query;
    }

    public function getRowsQueryWithoutFiltersProperty()
    {
        return Post::where('type','=','resource');
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->rowsQuery->paginate(24);
        });
    }

    public function render()
    {
        return view('resources::livewire.pages.home', [
            'resources' => $this->rows
        ]);
    }
}
