<?php

namespace Modules\Feeds\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Feeds\Actions\CreateFeedPostAction;
use Modules\Feeds\Models\FeedPost;
use Modules\Feeds\Services\FeedManager;

class ShowFeedController extends Controller
{
    public function __invoke($feedPayload)
    {
        $payload = app(FeedManager::class)->decryptFeedPayload($feedPayload);
        $uniqueFeedId = app(FeedManager::class)->uniqueFeedId($payload['url']);

        // Check if we already created a post for the feed url yet
        if ($feedPost = FeedPost::where('feed_id', $uniqueFeedId)->first()) {
            return redirect()->route('articles.show', $feedPost->post);
        }

        $feedPost = (new CreateFeedPostAction)->execute(
            url: $payload['url'],
            title: $payload['title'],
            author: $payload['author'],
            published_at: $payload['published_at'],
            content: $payload['content'],
            imageUrl: $payload['imageUrl'],
        );

        return redirect()->route('articles.show', $feedPost->post);
    }
}
