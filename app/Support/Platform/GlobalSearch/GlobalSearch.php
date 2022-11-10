<?php

namespace App\Support\Platform\GlobalSearch;

use Illuminate\Foundation\Auth\User;
use Spatie\Searchable\Search;
use Spatie\Searchable\SearchAspect;

class GlobalSearch extends Search
{
    public function perform(string $query, ?User $user = null): GlobalSearchResultCollection
    {
        $searchResults = new GlobalSearchResultCollection();

        collect($this->getSearchAspects())
            ->each(function (SearchAspect $aspect) use ($query, $user, $searchResults) {
                $searchResults->addResults($aspect->getType(), $aspect->getResults($query, $user));
            });

        return $searchResults;
    }
}
