<?php

namespace App\Policies;

use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Modules\Subscriptions\Models\SubscriptionType;
use Trans;

class TeamPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Team $team
     * @return mixed
     */
    public function view(User $user, Team $team)
    {
        return $user->belongsToTeam($team);
    }

    /**
     * Determine whether the user can apply to a team.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Team $team
     * @return mixed
     */
    public function apply(User $user, Team $team)
    {
        return in_array($user->chargentSubscription?->type?->slug, SubscriptionType::pluck('slug')->toArray());
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        $subscriptions = SubscriptionType::whereNot('slug', 'cfan-ea-member')->pluck('slug')->toArray();

        return in_array($user->chargentSubscription?->type?->slug, $subscriptions) 
            ? Response::allow() 
            : Response::deny(Trans::get('You must at least be an Associate Evangelist to create a Team'));
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Team $team
     * @return mixed
     */
    public function update(User $user, Team $team)
    {
        return $user->ownsTeam($team);
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
        return $user->ownsTeam($team);
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
        return $user->hasTeamRole($team, 'admin') || $user->ownsTeam($team);
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
    }

    public function manageMembership(User $user, Team $team)
    {
        return $user->ownsTeam($team);
    }
}
