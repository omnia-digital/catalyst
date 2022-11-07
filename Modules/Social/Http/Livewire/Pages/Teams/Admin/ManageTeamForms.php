<?php

namespace Modules\Social\Http\Livewire\Pages\Teams\Admin;

use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Forms\Models\Form;

class ManageTeamForms extends Component
{
    public ?Team $team;

    public $platformForms = [];
    public $teamForms = [];

    public $confirmingFormRemoval = false;
    public $formIdBeingRemoved = null;

    protected $listeners = ['formRemoved' => '$refresh'];

    public function onLoad()
    {
        $this->loadForms();
    }

    public function getUserProperty()
    {
        return Auth::user();
    }

    public function loadForms()
    {
        $platformForms = Form::whereNull('team_id')->get();

        $teamForms = Form::where('team_id', $this->team->id)->get();

        $this->platformForms = $platformForms;
        $this->teamForms = $teamForms;
    }

    public function confirmFormRemoval($formId)
    {
        $this->confirmingFormRemoval = true;

        $this->formIdBeingRemoved = $formId;
    }

    public function removeForm()
    {
        Form::find($this->formIdBeingRemoved)->delete();

        $this->confirmingFormRemoval = false;

        $this->formIdBeingRemoved = null;

        $this->emit('formRemoved');
    }

    public function render()
    {
        return view('social::livewire.pages.teams.admin.manage-team-forms', [
            'platformForms' => $this->platformForms,
            'teamForms' => $this->teamForms,
        ]);
    }
}
