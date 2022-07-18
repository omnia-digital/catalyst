<?php

namespace App\Traits\Filter;

trait WithSortAndFilters {

    public string $orderBy = 'created_at';

    public string $sortOrder = 'desc';

    public string $defaultSortOrder = 'desc';

    public array $filters = [
        'created_at' => '',
        'has_attachment' => false,
    ];

    public array $skipFilters = [];

    public $filterCount = 0;

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
        $this->filterCount = sizeof(array_filter($this->filters));
        $this->resetPage();
    }

    public function applyFilters($query)
    {
        $table = $query->first()?->getTable();

        $query = $query->when($this->filters['created_at'], function($q) use ($table) {
            return $q->whereDate($table.'.created_at', $this->filters['created_at']);
        });

        $query = $query->when($this->filters['has_attachment'], function($q) {
            return $q->having('media_count', '>=', 1);
        });

        return $query;
    }
}
