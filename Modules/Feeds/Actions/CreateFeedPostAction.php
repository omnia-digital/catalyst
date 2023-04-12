<?php

namespace Modules\Feeds\Actions;

use Illuminate\Support\Facades\DB;
use Modules\Feeds\Models\FeedPost;
use Modules\Feeds\Services\FeedManager;
use Modules\Social\Actions\Posts\CreateNewPostAction;
use Modules\Social\Enums\PostType;

class CreateFeedPostAction
{
    public function execute(string $url, string $content): FeedPost
    {
        return DB::transaction(function () use ($url, $content) {
            $post = (new CreateNewPostAction)
                ->type(PostType::FEED)
                ->execute($this->prependOriginalUrl($url, $content));

            return FeedPost::create([
                'feed_id' => app(FeedManager::class)->uniqueFeedId($url),
                'post_id' => $post->id,
            ]);
        });
    }

    protected function prependOriginalUrl(string $url, string $content): string
    {
        return "{$content} \n Source: {$url}";
    }
}
