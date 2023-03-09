<?php

namespace App\Policies;

use App\Models\User;
use App\Settings\BillingSettings;
use Illuminate\Auth\Access\HandlesAuthorization;

class BillingSettingsPolicy
{
    use HandlesAuthorization;

    private function isSuperAdmin(User $user)
    {
        return $user->hasRole('super-admin');
    }

    public function viewAny(User $user)
    {
        return $this->isSuperAdmin($user);
    }

    public function view(User $user, BillingSettings $billingSettings)
    {
        return $this->isSuperAdmin($user);
    }

    public function create(User $user)
    {
        return $this->isSuperAdmin($user);
    }

    public function update(User $user, BillingSettings $billingSettings)
    {
        return $this->isSuperAdmin($user);
    }

    public function delete(User $user, BillingSettings $billingSettings)
    {
        return $this->isSuperAdmin($user);
    }

    public function restore(User $user, BillingSettings $billingSettings)
    {
        return $this->isSuperAdmin($user);
    }

    public function forceDelete(User $user, BillingSettings $billingSettings)
    {
        return $this->isSuperAdmin($user);
    }
}
