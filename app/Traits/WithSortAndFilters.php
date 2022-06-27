<?php

namespace App\Traits;

trait WithSortAndFilters {

    public string $orderBy = 'created_at';

    public string $sortOrder = 'desc';

    public string $defaultSortOrder = 'desc';

    public function sortBy($key)
    {
        $this->sortOrder = ($this->orderBy === $key) ? $this->toggleSortOrder() : $this->defaultSortOrder;

        $this->orderBy = $key;
    }

    public function toggleSortOrder()
    {
        return ($this->sortOrder === 'asc') ? 'desc' : 'asc';
    }
    
    public function updatedFilters()
    {
        $this->resetPage();
    }
}