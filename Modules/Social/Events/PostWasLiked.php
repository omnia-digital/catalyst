<?php

namespace Modules\Social\Events;

use App\Contracts\Events\ContributesToUserScore;
use App\Events\BaseEvent;
use Illuminate\Queue\SerializesModels;
use Modules\Social\Models\UserScoreContribution;

class PostWasLiked extends BaseEvent implements ContributesToUserScore
{
    use SerializesModels;

    public function trackContributionToUserScore()
    {
        $this->user->profile->score += UserScoreContribution::getPointsFor('Post Was Liked');
        $this->user->profile->save();
    }
}
