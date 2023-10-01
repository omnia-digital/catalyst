<?php

namespace App\Traits\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use JetBrains\PhpStorm\Pure;

trait HasDefaultPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param $ability
     * @return bool|void|null
     */
    public function before(User $user, $ability)
    {
        return $this->adminBypass($user);
    }

    /**
     * Perform pre-authorization checks.
     *
     * @return void|bool
     */
    public function adminBypass(User $user)
    {
        if ($user->is_admin) {
            return true;
        }
    }

    public function create(): true
    {
        return true;
    }

    public function view(): true
    {
        return true;
    }

    public function viewAny(): true
    {
        return true;
    }

    public function destroy(): bool
    {
        return $this->delete();
    }

    public function delete()
    {
        return true;
    }

    public function restore()
    {
        return true;
    }

    public function forceDelete()
    {
        return true;
    }
}
