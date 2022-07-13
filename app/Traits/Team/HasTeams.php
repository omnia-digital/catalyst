<?php

namespace App\Traits\Team;

use App\Models\Membership;
use App\Models\Team;
use App\Models\User;
use Laravel\Jetstream\Jetstream;
use Spatie\Permission\Models\Role;

trait HasTeams
{
    public function teams()
    {
        return $this->roles()->whereNotNull('model_has_roles.team_id')
                             ->withTimestamps();
    }

    public function ownsTeam($team)
    {
        if (is_null($team)) {
            return false;
        }
        $currentTeamId = getPermissionsTeamId();
        setPermissionsTeamId($team->id);
        $response = $this->hasRole(config('platform.teams.default_owner_role'));
        setPermissionsTeamId($currentTeamId);

        return $response;
    }

    public function currentTeam()
    {
        if ( ! $this->teams()->exists()) {
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

    public function ownedTeams()
    {
        return $this->belongsToMany(Jetstream::teamModel(), Jetstream::membershipModel())->where(['role' => 'owner'])->withPivot('role')->withTimestamps()->as('membership');
    }

    public function hasTeamRole($team, string $role)
    {
        if ($this->ownsTeam($team)) {
            return true;
        }

        $userOnTeam = $team->users->where('id', $this->id)->first();

        if (empty($userOnTeam?->membership?->role)) {
            return false;
        }

        return $this->belongsToTeam($team) && optional(Jetstream::findRole($userOnTeam->membership->role))->key === $role;
    }

}
