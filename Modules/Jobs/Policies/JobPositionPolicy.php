<?php

namespace Modules\Jobs\Policies;

use App\Models\User;
use Modules\Jobs\Models\JobPosition;
use Illuminate\Auth\Access\HandlesAuthorization;

class JobPositionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User        $user
     * @param JobPosition $job
     *
     * @return mixed
     */
    public function view(User $user, JobPosition $job)
    {
        return true;
    }

    /**
     * @param User        $user
     * @param JobPosition $job
     *
     * @return bool
     */
    public function apply(User $user, JobPosition $job)
    {
        return $user->id !== $job->user_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User        $user
     * @param JobPosition $job
     *
     * @return mixed
     */
    public function update(User $user, JobPosition $job)
    {
        return $job->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User        $user
     * @param JobPosition $job
     *
     * @return mixed
     */
    public function delete(User $user, JobPosition $job)
    {
        return $job->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User        $user
     * @param JobPosition $job
     *
     * @return mixed
     */
    public function restore(User $user, JobPosition $job)
    {
        return $job->user_id === $user->id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User        $user
     * @param JobPosition $job
     *
     * @return mixed
     */
    public function forceDelete(User $user, JobPosition $job)
    {
        return $job->user_id === $user->id;
    }
}
