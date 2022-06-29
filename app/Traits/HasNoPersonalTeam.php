<?php

namespace App\Traits;

use Laravel\Jetstream\Jetstream;

trait HasNoPersonalTeam
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

    /**
     * Determine if the user is apart of any team.
     *
     * @param  mixed  $team
     * @return bool
     */
    public function isMemberOfATeam(): bool
    {
        return (bool) ($this->teams()->count() || $this->ownedTeams()->count());
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

        return $this->belongsToTeam($team) && optional(Jetstream::findRole($team->users->where(
                'id', $this->id
            )->first()?->membership?->role))->key === $role;
    }

}
