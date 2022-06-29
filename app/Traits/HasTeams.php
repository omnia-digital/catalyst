<?php

namespace App\Traits;

use Laravel\Jetstream\Jetstream;

trait HasTeams
{
    /**
     * Determine if the given team is the current team.
     *
     * @param  mixed  $team
     * @return bool
     */
    public function isCurrentTeam($team)
    {
        if (is_null($team)) {
            return false;
        }
        return $team?->id === $this->currentTeam->id;
    }

    public function isMemberOfATeam(): bool
    {
        dd($this->teams()->count());
        return dd((bool) ($this->teams()->count() || $this->ownedTeams()->count()));
    }

    public function ownedTeams()
    {
        return $this->hasMany(Jetstream::teamModel());
    }

    /**
     * Determine if the user has the given role on the given team.
     *
     * @param  mixed  $team
     * @param  string  $role
     * @return bool
     */
    public function hasTeamRole($team, string $role)
    {
        if ($this->ownsTeam($team)) {
            return true;
        }

        $userOnTeam = $team->users->where('id', $this->id)->first();

        if (empty($userOnTeam?->membership?->role)) { return false; }

        return $this->belongsToTeam($team) && optional(Jetstream::findRole($userOnTeam->membership->role))->key === $role;
    }

}
