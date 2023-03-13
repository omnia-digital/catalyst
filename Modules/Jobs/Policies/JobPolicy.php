<?php

namespace Modules\Jobs\Policies;

use Modules\Jobs\Models\Job;
use Modules\Jobs\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class JobPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \Modules\Jobs\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \Modules\Jobs\Models\User  $user
     * @param  \Modules\Jobs\Models\Job  $job
     * @return mixed
     */
    public function view(User $user, Job $job)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \Modules\Jobs\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \Modules\Jobs\Models\User  $user
     * @param  \Modules\Jobs\Models\Job  $job
     * @return mixed
     */
    public function update(User $user, Job $job)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \Modules\Jobs\Models\User  $user
     * @param  \Modules\Jobs\Models\Job  $job
     * @return mixed
     */
    public function delete(User $user, Job $job)
    {
        return true;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \Modules\Jobs\Models\User  $user
     * @param  \Modules\Jobs\Models\Job  $job
     * @return mixed
     */
    public function restore(User $user, Job $job)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \Modules\Jobs\Models\User  $user
     * @param  \Modules\Jobs\Models\Job  $job
     * @return mixed
     */
    public function forceDelete(User $user, Job $job)
    {
        //
    }
}
