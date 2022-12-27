<?php

namespace App\Http\Livewire\Pages\Companies;

use App\Models\Company;
use Livewire\Component;

class Show extends Component
{
    public $company;

    public function mount(Company $company)
    {
        $this->company = $company;

        visits($company)->increment();
    }

    public function render()
    {
        return view('livewire.pages.companies.show');
    }
}
