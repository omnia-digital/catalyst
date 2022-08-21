<?php

namespace App\Actions\Teams;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Jetstream\Contracts\InvitesTeamMembers;
use Laravel\Jetstream\Events\InvitingTeamMember;
use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\Mail\TeamInvitation;
use Laravel\Jetstream\Rules\Role;

class RemoveTeamApplication
{
    /**
     * Remove application for a user from the team.
     *
     * @param  mixed  $team
     * @param  int  $userID
     * @return void
     */
    public function remove($team, $userID)
    {
        $application = $team->teamApplications()
                        ->where('user_id', $userID)->first();

        if (! is_null($application)) {
            $application->delete();
        }
    }
}
