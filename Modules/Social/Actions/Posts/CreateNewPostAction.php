<?php

namespace Modules\Social\Actions\Posts;

use App\Models\Team;
use App\Models\User;
use App\Support\Platform\TextProcessor;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Traits\Conditionable;
use Modules\Social\Enums\PostType;
use Modules\Social\Models\Mention;
use Modules\Social\Models\Post;

class CreateNewPostAction
{
    use Conditionable;

    protected User|Authenticatable|null $user = null;

    protected ?Model $postable = null;

    protected ?Model $repost = null;

    protected ?PostType $type = null;

    protected ?Team $team = null;

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

    public function asRepost(Model $repost): self
    {
        $this->repost = $repost;

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

        $post = $user->posts()->create([
            'type'               => $this->type,
            'body'               => Mention::processMentionContent($content),
            'team_id'            => $options['team_id'] ?? null,
            'title'              => $options['title'] ?? null,
            'url'                => $options['url'] ?? null,
            'postable_id'        => $this->postable?->id ?? $options['postable_id'] ?? null,
            'postable_type'      => $this->postable ? get_class($this->postable) : ($options['postable_type'] ?? null),
            'repost_original_id' => $this->repost?->id,
            'image'              => $options['image'] ?? null,
        ]);

        [$userMentions, $teamMentions] = Mention::getAllMentions($content);

        Mention::createManyFromHandles($userMentions, User::class, $post);
        Mention::createManyFromHandles($teamMentions, Team::class, $post);

        return $post;
    }
}
