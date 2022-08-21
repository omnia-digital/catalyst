<?php

namespace Modules\Social\Actions;

use App\Models\Team;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Traits\Conditionable;
use Modules\Social\Enums\PostType;
use Modules\Social\Models\Post;

class CreateNewPostAction
{
    use Conditionable;

    protected User|Authenticatable|null $user = null;

    protected ?Model $postable = null;

    protected ?Model $repost = null;

    protected ?PostType $type = null;
}
