<?php

namespace Modules\Social\Http\Livewire\Pages\Teams\Forms;

use App\Models\Team;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;
use Modules\Forms\Models\Form;
use Modules\Forms\Traits\Livewire\WithFormBuilder;

class CreateEdit extends Component implements HasForms
{
    use WithFormBuilder;

    public Team $team;

    public ?Form $formModel;

    public function mount(Team $team, Form $form = null)
    {
        $this->team = $team;

        if ($form) {
            $this->formModel = $form;
            $this->form->fill($form->toArray());
        }
    }
    
    public function render()
    {
        return view('social::livewire.pages.teams.forms.create-edit');
    }
}