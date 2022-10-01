<?php

namespace Modules\Social\Http\Livewire\Pages\Teams\Admin;

use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Forms\Models\Form;

class ManageTeamForms extends Component
{
    public ?Team $team;

    public $platformForms;
    public $teamForms;

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

    public function render()
    {
        return view('social::livewire.pages.teams.admin.manage-team-forms', [
            'platformForms' => $this->platformForms,
            'teamForms' => $this->teamForms,
        ]);
    }
}
