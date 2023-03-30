<?php

namespace Modules\Livestream\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Livestream\Models\Series;
use Modules\Livestream\Models\User;

class NovaSeriesPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, Series $series): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Series $series): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Series $series): bool
    {
        return $user->isAdmin();
    }

    public function restore(User $user, Series $series): bool
    {
        //
    }

    public function forceDelete(User $user, Series $series): bool
    {
        //
    }
}
