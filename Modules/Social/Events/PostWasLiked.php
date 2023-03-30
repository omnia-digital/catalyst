<?php

namespace Modules\Social\Events;

use App\Contracts\Events\ContributesToUserScore;
use App\Events\BaseEvent;
use App\Models\User;
use Illuminate\Queue\SerializesModels;
use Modules\Social\Models\UserScoreContribution;

class PostWasLiked extends BaseEvent implements ContributesToUserScore
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function trackContributionToUserScore()
    {
        $this->user->profile->score += UserScoreContribution::getPointsFor('Liked User Post');
        $this->user->profile->save();
    }
}
