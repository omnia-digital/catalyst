<?php

namespace Modules\Jobs\Http\Livewire\Pages\Teams;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class UpdateCompanyForm extends Component
{
    public $company;

    public $state = [];

    /**
     * Mount the component.
     *
     * @param  mixed  $company
     * @return void
     */
    public function mount($company)
    {
        $this->company = $company;

        $this->state = ['about' => $company->about];
    }

    public function updateCompany()
    {
        $this->resetErrorBag();

        Gate::forUser($this->user)->authorize('update', $this->company);

        $this->company->update(['about' => $this->state['about'] ?? null]);

        $this->emit('saved');
    }

    public function getUserProperty()
    {
        return Auth::user();
    }

    public function render()
    {
        return view('livewire.teams.update-company-form');
    }
}
