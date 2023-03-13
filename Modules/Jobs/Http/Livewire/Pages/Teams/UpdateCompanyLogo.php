<?php

namespace Modules\Jobs\Http\Livewire\Teams;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdateCompanyLogo extends Component
{
    use WithFileUploads;

    public $company;

    public $photo;

    protected $rules = [
        'photo' => ['nullable', 'image', 'max:1024']
    ];

    protected $listeners = [
        'logo-removed' => '$refresh'
    ];

    public function mount($company)
    {
        $this->company = $company;
    }

    /**
     * Update company logo
     *
     * @return \Illuminate\Http\RedirectResponse|void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function updateCompanyLogo()
    {
        Gate::forUser(Auth::user())->authorize('update', $this->company);

        $this->validate();

        if ($this->photo) {
            $this->company->updateLogo($this->photo);

            return redirect()->route('teams.show', $this->company->id);
        }

        return;
    }

    public function deleteCompanyLogo()
    {
        Auth::user()->currentTeam->deleteLogo();

        $this->emitSelf('logo-removed');
    }

    public function render()
    {
        return view('teams.update-company-logo');
    }
}
