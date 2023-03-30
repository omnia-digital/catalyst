<?php

namespace Modules\Social\Events;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Social\Models\Like;
use Modules\Social\Models\UserScoreContribution;

class LikedUserPost implements TracksContributions
{
    use SerializesModels, Dispatchable;

    /**
     * The user instance.
     *
     * @param User|Authenticatable
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;

        $this->updateUserScore();
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }

    public function updateUserScore()
    {
        $this->user->profile->score += UserScoreContribution::getPointsFor("Liked User Post");
        $this->user->profile->save();
    }
}
