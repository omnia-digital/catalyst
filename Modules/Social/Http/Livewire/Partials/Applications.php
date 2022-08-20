<?php

namespace Modules\Social\Http\Livewire\Partials;

use App\Actions\Teams\RemoveTeamApplication;
use App\Models\Team;
use App\Models\TeamApplication;
use App\Models\TeamInvitation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\Contracts\AddsTeamMembers;
use Livewire\Component;

class Applications extends Component
{
    public $invitations;
    public $applications;

//    public function testClick()
//    {
//        $this->emit('team_action', "Invitation declined");
//    }
}
