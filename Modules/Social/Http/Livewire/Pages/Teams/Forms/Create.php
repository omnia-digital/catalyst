<?php

namespace Modules\Social\Http\Livewire\Pages\Teams\Forms;

use App\Models\Team;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;
use Modules\Forms\Traits\Livewire\WithFormBuilder;

class Create extends Component implements HasForms
{
    use WithFormBuilder;

    public Team $team;

    public function mount(Team $team)
    {
        $this->team = $team;
    }
    
    public function render()
    {
        return view('social::livewire.pages.teams.forms.create');
    }
}
