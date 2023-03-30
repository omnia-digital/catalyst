<?php

namespace Modules\Jobs\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Jobs\Models\JobPosition;

class JobPositionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
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
     *
     * @return mixed
     */
    public function view(User $user, JobPosition $job)
    {
        return true;
    }

    /**
     * @return bool
     */
    public function apply(User $user, JobPosition $job)
    {
        return $user->id !== $job->user_id;
    }

    /**
     * Determine whether the user can create models.
     *
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
     *
     * @return mixed
     */
    public function forceDelete(User $user, JobPosition $job)
    {
        return $job->user_id === $user->id;
    }
}
