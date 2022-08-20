<?php

namespace App\Traits\Team;

use Laravel\Jetstream\Jetstream;

trait HasTeams
{
    /**
     * Determine if the user owns the given team.
     *
     * @param  mixed  $team
     * @return bool
     */
    public function ownsTeam($team)
    {
        if (is_null($team)) {
            return false;
        }

        return $this->teams()->wherePivot('team_id', $team->id)->wherePivot('role', 'owner')->exists();
    }

    /**
     * @psalm-return \Illuminate\Database\Eloquent\Relations\BelongsTo<\Illuminate\Database\Eloquent\Model>|false
     */
    public function currentTeam(): \Illuminate\Database\Eloquent\Relations\BelongsTo|false
    {
        if (!$this->teams()->exists()) { return false;}

        if (is_null($this->current_team_id) && $this->id) {
            $team = $this->ownedTeams()->first() ?? $this->teams()->first();
            $this->switchTeam($team);
            $this->current_team_id = $team->id;
            $this->save();
        }

        return $this->belongsTo(Jetstream::teamModel(), 'current_team_id');
    }

    public function isCurrentTeam($team): bool
    {
        if (is_null($team)) {
            return false;
        }
        return $team?->id === $this->currentTeam->id;
    }

    public function isMemberOfATeam(): bool
    {
        return $this->teams()->count() > 0);
    }

    public function hasMultipleTeams(): bool
    {
        return $this->teams()->count() > 1);
    }

    public function ownedTeams()
    {
        return $this->belongsToMany(Jetstream::teamModel(), Jetstream::membershipModel())
                    ->where(['role'=>'owner'])
                    ->withPivot('role')
                    ->withTimestamps()
                    ->as('membership');
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
