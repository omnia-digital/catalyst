<?php

namespace App\Traits\Team;

use App\Models\Team;
use Laravel\Jetstream\Jetstream;
use Spatie\Permission\Models\Role;

trait HasTeams
{
    public function currentTeam()
    {
        if (!$this->teams()->exists()) {
            return false;
        }

        if (is_null($this->current_team_id) && $this->id) {
            $team = $this->ownedTeams()->first() ?? $this->teams()->first();
            $this->switchTeam($team);
            $this->current_team_id = $team->id;
            $this->save();
        }

        return $this->belongsTo(Jetstream::teamModel(), 'current_team_id');
    }

    public function teams()
    {
        return $this->morphToMany(Team::class, 'model', 'model_has_roles')
            ->withTimestamps()
            ->as('membership');
    }

    public function ownedTeams()
    {
        $ownerArray = $this->roles()
            ->whereIn('name', [config('platform.teams.default_owner_role')])
            ->get()
            ->pluck('id')
            ->toArray();

        return $this->morphToMany(Team::class, 'model', 'model_has_roles')
            ->as('membership')
            ->wherePivotIn('role_id', $ownerArray)
            ->withTimestamps();
    }

    public function isCurrentTeam($team)
    {
        if (is_null($team)) {
            return false;
        }

        return $team?->id === $this->currentTeam->id;
    }

    public function isMemberOfATeam(): bool
    {
        return (bool)($this->teams()->count() > 0);
    }

    public function hasMultipleTeams(): bool
    {
        return (bool)($this->teams()->count() > 1);
    }

    public function hasTeamRole($team, string $role)
    {
        if ($this->ownsTeam($team)) {
            return true;
        }

        $userOnTeam = $team->users->where('id', $this->id)->first();

        if (empty($userOnTeam?->membership?->role_id)) {
            return false;
        }

        return $this->belongsToTeam($team) && optional(Role::find($userOnTeam->membership->role_id))->name === $role;
    }

    public function ownsTeam($team)
    {
        if (is_null($team)) {
            return false;
        }

        return $this->is($team->owner);
        /* TODO: Do i need this?
        $currentTeamId = getPermissionsTeamId();
        setPermissionsTeamId($team->id);
        $response = $this->hasRole(config('platform.teams.default_owner_role'));
        setPermissionsTeamId($currentTeamId);

        return $response; */
    }

    /**
     * Get the role that the user has on the team.
     *
     * @param mixed $team
     * @return Role|null
     */
    public function teamRole($team)
    {
        if (!$this->belongsToTeam($team)) {
            return;
        }

        $roleId = $team->users->where('id', $this->id)->first()?->membership->role_id;
        $role = Role::find($roleId);

        return $role ?? null;
    }
}
