<?php namespace Modules\Livestream\Nova\Policies;

use Modules\Livestream\Models\Stream;
use Modules\Livestream\Models\User;
use Modules\Livestream\Policies\Traits\HasDefaultPolicy;

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
