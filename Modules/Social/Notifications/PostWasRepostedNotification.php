<?php

namespace Modules\Social\Notifications;

use App\Models\User;
use App\Support\Notification\NotificationCenter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;
use Modules\Social\Enums\PostType;
use Modules\Social\Models\Post;

class PostWasRepostedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private Post $post,
        private User $actionable
    ) {
    }

    public function toArray($notifiable): array
    {
        $url = $this->post->type === PostType::RESOURCE->value
            ? route('resources.show', $this->post)
            : route('social.posts.show', $this->post);

        $subtitle = $this->post->type === PostType::RESOURCE->value
            ? Str::of($this->post->body)->stripTags()->limit(155)
            : Str::of($this->post->body)->stripTags();

        return NotificationCenter::make()
            ->icon('heroicon-o-refresh')
            ->success($this->actionable->name . ' reposted your post')
            ->subtitle($subtitle)
            ->image($this->actionable->profile_photo_url)
            ->actionLink($url)
            ->actionText('View')
            ->toArray();
    }
}
