<?php

namespace App\Support\Platform\GlobalSearch;

use Illuminate\Support\Collection;
use Spatie\Searchable\SearchResultCollection;

class GlobalSearchResultCollection extends SearchResultCollection
{
    public function addResults(string $type, Collection $results)
    {
        $results->each(function ($result) use ($type) {
            $searchResultItem = $result->getSearchResult();

            $this->items[] = empty($searchResultItem->type) ? $searchResultItem->setType($type) : $searchResultItem;
        });

        return $this;
    }
}
