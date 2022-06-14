<?php

namespace Modules\Social\Http\Livewire\Pages\Projects;

use App\Models\Team;
use App\Actions\Teams\ApplyToTeam;
use App\Actions\Teams\RemoveTeamApplication;
use App\Models\TeamApplication;
use App\Models\User;
use App\Traits\WithTeamManagement;
use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\Contracts\AddsTeamMembers;
use Livewire\Component;

class Members extends Component
{
    use WithTeamManagement;

    public $team;

    protected $listeners = [
        'member_added' => '$refresh',
    ];

    public function mount(Team $team)
    {
        $this->team = $team;
    }

    public function render()
    {
        return view('social::livewire.pages.projects.members');
    }
}
