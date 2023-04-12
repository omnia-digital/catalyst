<?php

namespace Modules\Social\Notifications;

use App\Models\User;
use App\Support\Notification\NotificationCenter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;
use Modules\Social\Enums\PostType;
use Modules\Social\Models\Post;

class NewCommentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private Post $post,
        private User $actionable
    ) {
    }

    public function via($notifiable): array
    {
        if ($notifiable->id === $this->post->user_id) {
            return [];
        }

        return ['broadcast', 'database', 'mail'];
    }

    public function getTitle()
    {
        return $this->getMessage();
    }

    public function getSubTitle()
    {
        return $this->post->type === PostType::ARTICLE->value
            ? Str::of($this->post->body)->stripTags()->limit(155)
            : Str::of($this->post->body)->stripTags();
    }

    public function getMessage()
    {
        return $this->actionable->name . ' left a comment in your post';
    }

    public function getUrl()
    {
        return $this->post->type === PostType::ARTICLE->value
            ? route('resources.show', $this->post)
            : route('social.posts.show', $this->post);
    }

    public function getImage()
    {
        return $this->actionable->profile_photo_url;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->greeting($this->getTitle())
            ->line($this->getMessage())
            ->action('View Notifications', $this->getUrl());
    }

    public function toArray($notifiable): array
    {
        return NotificationCenter::make()
            ->icon('heroicon-o-chat-alt')
            ->success($this->getMessage())
            ->subtitle($this->getSubTitle())
            ->image($this->getImage())
            ->actionLink($this->getUrl())
            ->actionText('View')
            ->toArray();
    }
}
