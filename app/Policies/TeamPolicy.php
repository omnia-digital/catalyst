<?php

namespace App\Policies;

use App\Models\Team;
use App\Models\User;
use App\Support\Platform\Platform;
use App\Traits\Policies\HasDefaultPolicy;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Billing\Models\SubscriptionType;
use Response;
use Trans;

class TeamPolicy
{
    use HandlesAuthorization, HasDefaultPolicy;

    public function apply(User $user, Team $team): bool
    {
        if (! Platform::isUsingUserSubscriptions()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_team');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Team $team): bool
    {
        return $user->can('view_team');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //        return $user->can('create_team');

        if (! Platform::isUsingUserSubscriptions()) {
            return true;
        }

        $subscriptions = SubscriptionType::whereNot('slug', 'cfan-ea-member')->pluck('slug')->toArray();

        return in_array($user->chargentSubscription?->type?->slug, $subscriptions)
            ? Response::allow()
            : Response::deny(Trans::get('You must at least be an Associate Evangelist to create a Team'));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Team $team): bool
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

        return false;
    }

    /**
     * Determine whether the user can add team members.
     */
    public function addTeamMember(User $user, Team $team): bool
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
     */
    public function updateTeamMember(User $user, Team $team): bool
    {
        return $user->ownsTeam($team);
    }

    /**
     * Determine whether the user can give a team member an award.
     *
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
     * @return mixed
     */
    public function addReview(User $user, Team $team)
    {
        return $user->belongsToTeam($team);
    }

    /**
     * Determine whether the user can remove team members.
     */
    public function removeTeamMember(User $user, Team $team): bool
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
     */
    public function delete(User $user, Team $team): bool
    {
        return $user->ownsTeam($team);
        //        return $user->can('delete_team');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_team');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, Team $team): bool
    {
        return $user->can('force_delete_team');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_team');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, Team $team): bool
    {
        return $user->can('restore_team');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_team');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, Team $team): bool
    {
        return $user->can('replicate_team');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_team');
    }

    /**
     * Determine whether the user can create roles for the team.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function createTeamRole(User $user, Team $team)
    {
        return $user->ownsTeam($team);
    }

    /**
     * Determine whether the user can update existing roles for the team.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function updateTeamRole(User $user, Team $team)
    {
        return $user->ownsTeam($team);
    }

    /**
     * Determine whether the user can delete existing roles for the team.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function deleteTeamRole(User $user, Team $team)
    {
        return $user->ownsTeam($team);
    }
}
