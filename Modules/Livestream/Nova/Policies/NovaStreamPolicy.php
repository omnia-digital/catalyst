<?php namespace App\Nova\Policies;

use App\Models\Stream;
use App\Models\User;
use App\Policies\Traits\HasDefaultPolicy;

class NovaStreamPolicy
{
    use HasDefaultPolicy;

    public function create(User $user)
    {
        return false;
    }

    public function update(User $user, Stream $stream)
    {
        return false;
    }

    public function delete(User $user, Stream $stream)
    {
        return false;
    }
}
