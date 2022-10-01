<?php

namespace Modules\Social\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\Mention\MentionExtension;
use Modules\Social\Models\Mention;
use Modules\Social\Models\Post;

trait Postable
{
    /**
     * Get the posts for the current model
     */
    public function posts(): MorphMany
    {
        // @NOTE - we have to remove the 'parent' globalscope in order to retrieve comments
        return $this->morphMany(Post::class, 'postable')
            ->withoutGlobalScope('parent');
    }

    /**
     * Handles creating the post for the current model
     */
    public function createPost($data, $userId): Model|Post
    {
        $mentions = $this->getMentions($data['body']);

        foreach ($mentions as $mention) {
            $profileUrl = config('app.url') . '/social/profiles/' . $mention;
            $htmlTag = "<a href='{$profileUrl}'>@{$mention}</a>";

            $body = str_replace("@{$mention}", $htmlTag, $data['body']);
        }

        /* $config = [
            'mentions' => [
                'user_handle' => [
                    'symbol' => '@',
                    'regex' => '/^[A-Za-z0-9_]{1,15}(?!\w)/',
                    'generator' => config('app.url') . '/social/profiles/%s',
                ],
            ]
        ];
        $commonMark = new CommonMarkConverter($config); */

        return $this->posts()->create([
            'user_id' => $userId,
            'body' => $body,
        ]);
    }

    public function createMention($mention, $userId)
    {
        //MentionMention
    }

    public function getMentions($content)
    {
        $regexForMentions = "/\B@([a-z0-9_-]+)/i";
        $mentions = array();

        preg_match_all($regexForMentions, $content, $mentions);

        return $mentions[1];
    }

    //** Aliases **//
    /**
     * Alias for posts()
     */
    public function comments(): MorphMany
    {
        return $this->posts();
    }

    /**
     * Alias for createPost()
     */
    public function createComment($data, $userId): Model|Post
    {
        return $this->createPost($data, $userId);
    }
}
