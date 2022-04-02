<?php

namespace Modules\Social\Actions;

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

    protected ?PostType $type = null;

    public function user(User|Authenticatable $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function asComment(Model $parent): self
    {
        $this->postable = $parent;

        return $this;
    }

    public function type(?PostType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function execute(string $content, array $options = []): Post
    {
        $user = $this->user ?? Auth::user();

        return $user->posts()->create([
            'body'          => $content,
            'team_id'       => $options['team_id'] ?? $user->current_team_id,
            'title'         => $options['title'] ?? null,
            'type'          => $this->type,
            'postable_id'   => $this->postable->id ?? $options['postable_id'] ?? null,
            'postable_type' => $this->postable ? get_class($this->postable) : ($options['postable_type'] ?? null),
            'image'         => $options['image'] ?? null,
            'published_at'  => now(),
        ]);
    }
}
