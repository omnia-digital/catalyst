<?php

namespace Modules\Feeds\Actions;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Modules\Feeds\Models\FeedPost;
use Modules\Feeds\Services\FeedManager;
use Modules\Social\Actions\Posts\CreateNewPostAction;
use Modules\Social\Enums\PostType;

class CreateFeedPostAction
{
    public function execute(string $url, string $content, string $title, string $author, string $published_at, string $imageUrl): FeedPost
    {
        // check if it's an article type of feed, choose which type of post to create here
        // For now, let's just assume every new feed item is an article
        $postType = PostType::ARTICLE;

        // Try to find the user based on email first, then fallback to first and last name.
        // If we can't find one,
        $user = User::findByEmail($author);
        if (empty($user)) {
            $user = User::findByFullName(fullName: $author);
        }
        // should we create a user account for the feed? The problem is FeedSources like YouTube will look like YouTube Posted it.

        // I do think we should try to grab the first image if we don't have an image set already and use that as the image for the article.
        $image = $imageUrl;

        return DB::transaction(function () use ($postType, $url, $content, $title, $author, $published_at, $user) {
            $options = [
                'title' => $title,
                'author' => $author,
                'published_at' => $published_at,
                'url' => $url,
            ];
            $post = (new CreateNewPostAction);

            if (! empty($user)) {
                $post->user($user);
            }
            $post->type($postType);

            $post = $post->execute($content, $options);

            return FeedPost::create([
                'feed_id' => app(FeedManager::class)->uniqueFeedId($url),
                'post_id' => $post->id,
            ]);
        });
    }
}
