<?php namespace App\Policies;

use App\Models\StreamTarget;
use App\Models\User;
use App\Policies\Traits\HasDefaultPolicy;

class StreamTargetPolicy
{
    use HasDefaultPolicy;

    public function view(User $user, StreamTarget $streamTarget)
    {
        return false;
    }

    public function update(User $user, StreamTarget $streamTarget)
    {
        return $streamTarget->stream->livestreamAccount->id === $user->currentTeam->livestreamAccount->id;
    }

    public function delete(User $user, StreamTarget $streamTarget)
    {
        return $streamTarget->stream->livestreamAccount->id === $user->currentTeam->livestreamAccount->id;
    }
}
