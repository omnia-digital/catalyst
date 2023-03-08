<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Team;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Billing\Models\SubscriptionType;
use Platform;
use Response;
use Trans;

class TeamPolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     *
     * @param  \App\Models\User  $user
     * @return void|bool
     */
    public function before(User $user)
    {
        if ($user->is_admin) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->can('view_any_team');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Team $team)
    {
        return $user->can('view_team');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
//        return $user->can('create_team');

        if(!Platform::isUsingUserSubscriptions()) return true;

        $subscriptions = SubscriptionType::whereNot('slug', 'cfan-ea-member')->pluck('slug')->toArray();

        return in_array($user->chargentSubscription?->type?->slug, $subscriptions)
            ? Response::allow()
            : Response::deny(Trans::get('You must at least be an Associate Evangelist to create a Team'));
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Team $team)
    {
//        return $user->can('update_team');

        if ($user->ownsTeam($team)) {
            return true;
        }

        if ($user->belongsToTeam($team)) {
            if ($user->teamRole($team)->hasPermissionTo('update team')) {
                return true;
            }
        }
    }


    /**
     * Determine whether the user can add team members.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Team $team
     * @return mixed
     */
    public function addTeamMember(User $user, Team $team)
    {
        if ($user->ownsTeam($team)) {
            return true;
        }

        if ($user->belongsToTeam($team)) {
            if ($user->teamRole($team)?->hasPermissionTo('update team')) {
                return true;
            }
        }
    }

    /**
     * Determine whether the user can update team member permissions.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Team $team
     * @return mixed
     */
    public function updateTeamMember(User $user, Team $team)
    {
        return $user->ownsTeam($team);
    }

    /**
     * Determine whether the user can give a team member an award.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Team $team
     * @return mixed
     */
    public function addAwardToTeamMember(User $user, Team $team)
    {
        if ($user->ownsTeam($team)) {
            return true;
        }

        if ($user->belongsToTeam($team)) {
            if ($user->teamRole($team)->hasPermissionTo('give team award')) {
                return true;
            }
        }
    }

    /**
     * Determine whether the user can leave a review for the team.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Team  $team
     * @return mixed
     */
    public function addReview(User $user, Team $team)
    {
        return $user->belongsToTeam($team);
    }

    /**
     * Determine whether the user can remove team members.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Team $team
     * @return mixed
     */
    public function removeTeamMember(User $user, Team $team)
    {
        if ($user->ownsTeam($team)) {
            return true;
        }

        if ($user->belongsToTeam($team)) {
            if ($user->teamRole($team)->hasPermissionTo('update team')) {
                return true;
            }
        }
    }

    public function manageMembership(User $user, Team $team)
    {
        return $user->ownsTeam($team);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Team $team
     * @return mixed
     */
    public function delete(User $user, Team $team)
    {
        return $user->ownsTeam($team);
//        return $user->can('delete_team');

    }

    /**
     * Determine whether the user can bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function deleteAny(User $user)
    {
        return $user->can('delete_any_team');
    }

    /**
     * Determine whether the user can permanently delete.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Team $team)
    {
        return $user->can('force_delete_team');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDeleteAny(User $user)
    {
        return $user->can('force_delete_any_team');
    }

    /**
     * Determine whether the user can restore.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Team $team)
    {
        return $user->can('restore_team');
    }

    /**
     * Determine whether the user can bulk restore.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restoreAny(User $user)
    {
        return $user->can('restore_any_team');
    }

    /**
     * Determine whether the user can replicate.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function replicate(User $user, Team $team)
    {
        return $user->can('replicate_team');
    }

    /**
     * Determine whether the user can reorder.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function reorder(User $user)
    {
        return $user->can('reorder_team');
    }

    /**
     * Determine whether the user can create roles for the team.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function createTeamRole(User $user, Team $team)
    {
        return $user->ownsTeam($team);
    }

    /**
     * Determine whether the user can update existing roles for the team.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function updateTeamRole(User $user, Team $team)
    {
        return $user->ownsTeam($team);
    }

    /**
     * Determine whether the user can delete existing roles for the team.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function deleteTeamRole(User $user, Team $team)
    {
        return $user->ownsTeam($team);
    }

}
