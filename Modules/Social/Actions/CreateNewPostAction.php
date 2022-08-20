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

    public function asComment(Model $parent): static
    {
        $this->postable = $parent;

        return $this;
    }

    public function asRepost(Model $repost): static
    {
        $this->repost = $repost;

        return $this;
    }

    public function type(?PostType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function execute(string $content, array $options = []): Post
    {
        $user = $this->user ?? Auth::user();

        return $user->posts()->create([
            'body'               => $content,
            'team_id'            => $options['team_id'] ?? null,
            'title'              => $options['title'] ?? null,
            'type'               => $this->type,
            'postable_id'        => $this->postable?->id ?? $options['postable_id'] ?? null,
            'postable_type'      => $this->postable ? get_class($this->postable) : ($options['postable_type'] ?? null),
            'repost_original_id' => $this->repost?->id,
            'image'              => $options['image'] ?? null,
        ]);
    }
}
