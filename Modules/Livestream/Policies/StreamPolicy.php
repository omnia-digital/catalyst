<?php namespace App\Policies;

use App\Models\Stream;
use App\Models\User;
use App\Policies\Traits\HasDefaultPolicy;

class StreamPolicy
{
    use HasDefaultPolicy;

    public function view(User $user, Stream $stream)
    {
        return $stream->livestream_account_id === $user->currentTeam->livestreamAccount->id;
    }

    public function create(User $user)
    {
        return false;
    }

    public function update(User $user, Stream $stream)
    {
        return $stream->livestream_account_id === $user->currentTeam->livestreamAccount->id;
    }

    public function delete(User $user, Stream $stream)
    {
        return false;
    }

}
