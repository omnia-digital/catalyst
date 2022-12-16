<?php

namespace App\Observers;

use App\Models\Membership;
use Spatie\Permission\Models\Role;

class MembershipObserver
{
    public function created(Membership $membership)
    {
        // if there is no role given
        if (empty($membership->role_id)) {
            if (!empty($membership->team_id)) {
                setPermissionsTeamId($membership->team_id);
            }

            // set the role to the default role
            $membership->role_id = Role::findOrCreate(config('platform.teams.default_owner_role'))->id;
            // save the membership
            $membership->save();
        }
    }

    public function updated(Membership $membership)
    {
    }

    public function deleted(Membership $membership)
    {
    }

    public function restored(Membership $membership)
    {
    }

    public function forceDeleted(Membership $membership)
    {
    }
}
