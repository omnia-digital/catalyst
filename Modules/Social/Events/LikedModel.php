<?php

namespace Modules\Social\Events;

use App\Contracts\Events\ContributesToUserScore;
use App\Events\BaseEvent;
use App\Models\User;
use Illuminate\Queue\SerializesModels;
use Modules\Social\Models\Post;
use Modules\Social\Models\UserScoreContribution;

class LikedModel extends BaseEvent implements ContributesToUserScore
{
    use SerializesModels;

    /**
     * The user instance.
     *
     * @param User|Authenticatable
     */
    public $user;

    /**
     * The likable instance.
     * 
     * @param mixed
     */
    public $model;

    /**
     * Match model class to contribution type
     * 
     * @param array
     */
    public $modelClassEvents =[
        Post::class => LikedUserPost::class,
    ];

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, $model)
    {
        $this->user = $user;
        $this->model = $model;
    }

    public function trackContributionToUserScore()
    {
        $this->modelClassEvents[$this->model::class]::dispatch($this->user, $this->model);
    }
}
