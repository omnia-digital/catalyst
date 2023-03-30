<?php

namespace Modules\Livestream\Http\Livewire\Person;

use Modules\Livestream\Models\person;
use Modules\Livestream\Support\Livewire\WithNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

/**
 * @property array $organizations
 */
class DeletePerson extends Component
{
    use WithNotification, AuthorizesRequests;

    public bool $deletepersonModalOpen = false;

    public person $person;

    public bool $loading = false;

    protected $listeners = [
        'person-deleted'    => 'handlepersonDeleted'
    ];
    protected function rules(): array
    {
        return [];
    }

    public function deleteperson()
    {
        $this->loading = true;
        $this->authorize('delete', $this->person);

        if ($this->person->video?->isProcessing()) {
            $this->error('This video is processing so you cannot delete it right now.');
            $this->loading = false;

            return;
        }

        $this->person->purge();

        $this->success('Person has been successfully deleted!');
        $this->loading = false;
        $this->redirectRoute('people');
    }

    public function render()
    {
        return view('person.delete');
    }
}
