<?php

namespace Modules\Social\Notifications;

use App\Models\User;
use App\Support\Notification\NotificationCenter;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\Social\Enums\PostType;
use Modules\Social\Models\Post;
use Str;
use Trans;

class SomeoneMentionedYouNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        private Post $post
    ) {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if ($notifiable->id === $this->post->user_id) {
            return [];
        }

        return ['broadcast', 'database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $url = route('social.posts.show', $this->post);
        $subtitle = $this->post->type === PostType::RESOURCE->value
            ? Str::of($this->post->body)->stripTags()->limit(155)
            : Str::of($this->post->body)->stripTags();

        return NotificationCenter::make()
            ->icon('heroicon-o-user-group')
            ->success(Trans::get($this->post->user->name . ' mentioned you in their post'))
            ->image($this->post->user->profile_photo_url)
            ->subtitle($subtitle)
            ->actionLink($url)
            ->actionText('View')
            ->toArray();
    }
}
