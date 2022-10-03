<?php

namespace Modules\Social\Actions\Posts;

use App\Models\Team;
use App\Models\User;
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
            'body'               => $this->replaceMentionsWithLinks($content),
            'team_id'            => $options['team_id'] ?? null,
            'title'              => $options['title'] ?? null,
            'url'                => $options['url'] ?? null,
            'postable_id'        => $this->postable?->id ?? $options['postable_id'] ?? null,
            'postable_type'      => $this->postable ? get_class($this->postable) : ($options['postable_type'] ?? null),
            'repost_original_id' => $this->repost?->id,
            'image'              => $options['image'] ?? null,
        ]);

        [$userMentions, $teamMentions] = $this->getAllMentions($content);

        Mention::createManyFromHandle($userMentions, User::class, $post);
        Mention::createManyFromHandle($teamMentions, Team::class, $post);

        return $post;
    }

    private function getAllMentions($content)
    {
        $userMentions = $teamMentions = array();

        preg_match_all(Mention::USER_HANDLE_REGEX, $content, $userMentions);
        preg_match_all(Mention::TEAM_HANDLE_REGEX, $content, $teamMentions);

        return [$userMentions[1], $teamMentions[1]];
    }

    private function replaceMentionsWithLinks($content)
    {

        $content = $this->replaceUserMentions($content);

        $content = $this->replaceTeamMentions($content);

        return $content;
    }

    private function replaceUserMentions($content)
    {
        return preg_replace_callback(
            Mention::USER_HANDLE_REGEX, 
            function ($matches) {
                if (is_null(User::findByHandle($matches[1]))) return $matches[0];

                return "<a x-data x-on:click.stop='' class='hover:underline hover:text-secondary' href='" . route('social.profile.show', $matches[1]) . "'>" . $matches[0] . "</a>";
            },
            $content
        );
    }

    private function replaceTeamMentions($content)
    {
        return preg_replace_callback(
            Mention::TEAM_HANDLE_REGEX, 
            function ($matches) {
                if (is_null(Team::findByHandle($matches[1]))) {
                    return $matches[0];
                }

                return "<a x-data x-on:click.stop='' class='hover:underline hover:text-secondary' href='" . route('social.teams.show', $matches[1]) . "'>" . $matches[0] . "</a>";
            },
            $content
        );
    }
}
