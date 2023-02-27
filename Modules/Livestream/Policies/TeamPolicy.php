<?php

namespace App\Policies;

use App\Models\Team;
use App\Models\User;
use App\Policies\Traits\HasDefaultPolicy;

class TeamPolicy
{
    use HasDefaultPolicy;

    public function view(User $user, Team $team) : bool
    {
        return $user->belongsToTeam($team);
    }

    public function update(User $user, Team $team)
    {
        return $user->ownsTeam($team);
    }

    public function addTeamMember(User $user, Team $team)
    {
        return $user->ownsTeam($team);
    }

    public function updateTeamMember(User $user, Team $team)
    {
        return $user->ownsTeam($team);
    }

    public function removeTeamMember(User $user, Team $team)
    {
        return $user->ownsTeam($team);
    }

    public function delete(User $user, Team $team)
    {
        return $user->ownsTeam($team);
    }
}
