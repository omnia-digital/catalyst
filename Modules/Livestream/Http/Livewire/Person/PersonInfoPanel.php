<?php

namespace Modules\Livestream\Http\Livewire\Person;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Modules\Livestream\Models\Person;
use Modules\Livestream\Support\Livewire\WithNotification;
use Modules\Livestream\Support\Livewire\WithSlideOver;

class PersonInfoPanel extends Component
{
    use WithNotification, AuthorizesRequests, WithSlideOver;

    public ?Person $person = null;

    public bool $isDetailPage = false;

    public array $state = [];

    public bool $editModalOpen = false;

    protected $listeners = [
        'personSelected' => 'findPerson',
        'person-deselected' => 'resetPerson',
    ];

    protected $rules = [
        'state.first_name' => ['required', 'max:254'],
        'state.last_name' => ['required', 'max:254'],
        'state.email' => ['required', 'email'],
    ];

    public function mount($personId = null)
    {
        $this->isDetailPage = request()->routeIs('people.show');

        $this->findPerson($personId);

        // Only check view permission on the detail page
        if ($personId) {
            $this->authorize('view', $this->person);
        }
    }

    public function showEditModal()
    {
        $this->editModalOpen = true;
    }

    public function hideEditModal()
    {
        $this->editModalOpen = false;
    }

    public function updatePerson()
    {
        $this->authorize('update', $this->person);

        $this->validate();

        $this->person->update($this->state);

        $this->success('Update person successfully!');
        $this->hideEditModal();
    }

    public function findPerson($personId)
    {
        // Don't do anything when user select same person.
        if ($personId === $this->person?->id) {
            return;
        }

        $this->person = Person::find($personId);

        // Fill data for the edit form,
        // we don't want to use the data from model binding
        // because it will show title as empty when user delete title in the edit form.
        $this->state = $this->person?->only(['first_name', 'last_name', 'email']) ?? [];

        // Dispatch event for open the over-slide on mobile
        $this->showSlideOver();
    }

    public function resetPerson()
    {
        $this->reset('person');
    }

    public function render()
    {
        return view('person.person-info-panel');
    }
}
