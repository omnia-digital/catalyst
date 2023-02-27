<?php

namespace App\Policies;

use App\Models\Series;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

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
