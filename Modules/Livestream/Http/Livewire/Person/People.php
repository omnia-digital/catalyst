<?php

namespace Modules\Livestream\Http\Livewire\Person;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Livestream\Models\Person;
use Modules\Livestream\Support\Livewire\WithCachedRows;
use Modules\Livestream\Support\Livewire\WithLayoutSwitcher;
use Modules\Livestream\Support\Livewire\WithNotification;

/**
 * @property Builder $rowsQueryWithoutFilters
 */
class People extends Component
{
    use WithPagination, WithLayoutSwitcher, WithCachedRows, WithNotification;

    public bool $addPersonModalOpen = false;

    public array $person = [];

    public ?int $selectedPerson = null;

    public ?string $search = null;

    public string $orderBy = 'first_name';

    protected $listeners = [
        'person-deselected' => 'deselectPerson',
        'person-deleted' => '$refresh',
    ];

    protected $queryString = [
        'search',
    ];

    public function mount(Person $person)
    {
        $this->selectPerson($person->id);
    }

    public function selectPerson($person)
    {
        $this->useCachedRows();

        $this->selectedPerson = $person;

        $this->dispatch('personSelected', person: $person)->to('person.person-info-panel');
    }

    public function updatedFilters()
    {
        $this->resetPage();
    }

    public function deselectPerson()
    {
        $this->useCachedRows();

        $this->reset('selectedPerson');
    }

    public function addPerson()
    {
        $validated = $this->validate([
            'person.first_name' => ['required', 'max:254'],
            'person.last_name' => ['required', 'max:254'],
            'person.email' => ['required', 'email'],
        ]);

        $person = Person::create($validated['person']);
        auth()->user()->currentTeam->people()->attach($person->id);

        $this->reset('addPersonModalOpen');
        $this->success('Add person successfully!');
    }

    public function sortBy(string $orderBy)
    {
        if ($orderBy === $this->orderBy) {
            return;
        }

        $this->orderBy = $orderBy;
    }

    public function getRowsQueryProperty()
    {
        $query = clone $this->rowsQueryWithoutFilters;

        return $query
            ->when(! empty($this->search), fn ($query) => $query->search($this->search))
            ->when($this->orderBy === 'first_name', fn ($query) => $query->orderBy('first_name', 'asc'))
            ->when($this->orderBy === 'created_at', fn ($query) => $query->orderBy('created_at', 'asc'));
    }

    public function getRowsQueryWithoutFiltersProperty()
    {
        return auth()->user()->currentTeam
            ?->people()
            ->with(['user']);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->rowsQuery->paginate(24);
        });
    }

    public function render()
    {
        return view('person.people', [
            'people' => $this->rows,
        ]);
    }
}
