<?php

namespace App\Traits;

trait WithSortAndFilters {

    public string $orderBy = 'created_at';

    public string $sortOrder = 'desc';

    public string $defaultSortOrder = 'desc';

    public array $filters = [
        'created_at' => '',
        'has_attachment' => false,
    ];

    public function sortBy($key)
    {
        $this->sortOrder = $this->defaultSortOrder;

        $this->orderBy = $key;
    }

    public function toggleSortOrder()
    {
        $this->sortOrder = ($this->sortOrder === 'asc') ? 'desc' : 'asc';
    }
    
    public function updatedFilters()
    {
        $this->resetPage();
    }

    public function applyFilters($query)
    {
        if ($this->filters['created_at'] != '') {
            $query = $query->whereDate('created_at', $this->filters['created_at']);
        }

        if ($this->filters['has_attachment']) {
            $query = $query->having('media_count', '>=', 1);
        }

        return $query;
    }
}