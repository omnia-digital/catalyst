<?php

namespace Modules\Social\Notifications;

use App\Models\Team;
use App\Notifications\BaseNotification;
use App\Support\Notification\NotificationCenter;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;
use Modules\Social\Enums\PostType;
use Modules\Social\Models\Mention;
use Trans;

class SomeoneMentionedYouNotification extends BaseNotification
{
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        private Mention $mention
    ) {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if ($notifiable->id === $this->mention->postable->user_id) {
            return [];
        }

        return static::getChannels();
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $url = route('social.posts.show', $this->mention->postable);

        $message = $this->mention->mentionable::class === Team::class
            ? Trans::get($this->mention->postable->user->name . ' mentioned your team, ' . $this->mention->mentionable->name . ' in their post')
            : Trans::get($this->mention->postable->user->name . ' mentioned you in their post');

        $subtitle = $this->mention->postable->type === PostType::ARTICLE->value
            ? Str::of($this->mention->postable->body)->stripTags()->limit(155)
            : Str::of($this->mention->postable->body)->stripTags();

        return NotificationCenter::make()
            ->icon('heroicon-o-user-group')
            ->success($message)
            ->image($this->mention->postable->user->profile_photo_url)
            ->subtitle($subtitle)
            ->actionLink($url)
            ->actionText('View')
            ->toArray();
    }
}
