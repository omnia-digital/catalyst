<?php

namespace App\Livewire\Partials;

use App\Models\Team;
use App\Support\Platform\GlobalSearch\GlobalSearch as Search;
use Illuminate\Support\Collection;
use Livewire\Component;
use Modules\Social\Models\Post;
use Modules\Social\Models\Profile;
use Spatie\Searchable\SearchResultCollection;

class GlobalSearch extends Component
{
    public ?string $search = null;

    public SearchResultCollection|Collection $searchResults;

    public function updatedSearch($value)
    {
        if (empty($value)) {
            $this->searchResults = new SearchResultCollection;

            return;
        }

        $this->searchResults = (new Search)
            ->registerModel(Post::class, 'title')
            ->registerModel(Team::class, 'name', 'handle')
            ->registerModel(Profile::class, 'first_name', 'last_name', 'handle')
            ->search($value);
    }

    public function render()
    {
        return view('livewire.partials.global-search');
    }
}
