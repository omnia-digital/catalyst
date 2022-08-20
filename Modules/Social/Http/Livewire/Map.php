<?php

namespace Modules\Social\Http\Livewire;

use App\Models\ContactCategory;
use Illuminate\Support\Arr;
use Livewire\Component;
use Squire\Models\Country;

class Map extends Component
{
    public $selectedCategoryId = 'All';

    public $filters = [
        'country'
    ];

    public function updatedFilters($value, $key): void
    {
        //$this->dispatchBrowserEvent('refresh-map', $this->rows);

        if ($key === 'country' && $value !== 'All') {
            $this->dispatchBrowserEvent('focus-to-country', strtoupper($value));
        }
    }

    public function selectCategory($id): void
    {
        $this->selectedCategoryId = $id;

        $this->dispatchBrowserEvent('refresh-map', $this->rows);
    }

    /**
     * @return string[]
     *
     * @psalm-return array{0: 'Category 1', 1: 'Category 2', 2: 'Category 3'}
     */
    public function getCategoriesProperty(): array
    {
        return ['Category 1', 'Category 2', 'Category 3'];//ContactCategory::all();
    }

    public function getRowsQueryProperty()
    {
        $country = Arr::get($this->filters, 'country');

        return null;/* Contact::query()
            ->with('contactCategories')
            ->available()
            ->when($this->selectedCategoryId && $this->selectedCategoryId !== 'All', fn($query, $category) => $query->whereHas('contactCategories', fn($query) => $query->where('contact_category_id', $this->selectedCategoryId)))
            ->when(!empty($country) && $country !== 'All', fn($query) => $query->where('country', $country)); */
    }

    public function getRowsProperty()
    {
        return null;//$this->rowsQuery->get();
    }

    public function render(): \Illuminate\View\View
    {
        return view('social::livewire.components.map', [
            'countries'  => Country::orderBy('name')->get(),
        ]);
    }
}
