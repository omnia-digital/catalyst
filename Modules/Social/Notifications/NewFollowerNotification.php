<?php

namespace Modules\Social\Notifications;

use App\Models\User;
use App\Support\Notification\NotificationCenter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Modules\Social\Enums\PostType;

class NewFollowerNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private User $follower
    ){}

    public function via($notifiable): array
    {
        if ($notifiable->id === $this->follower->id) {
            return [];
        }

        return ['broadcast', 'database', 'mail'];
    }

    public function getTitle()
    {
        return \Trans::get("You have a new follower");
    }

    public function getMessage()
    {
        return $this->follower->name . \Trans::get(' followed you');
    }

    public function getUrl()
    {
        return $this->follower->url() ?? route('notifications');
    }

    public function getImage()
    {
        return $this->follower->profile_photo_url;
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
            ->icon('heroicon-o-user')
            ->info($this->getMessage())
            ->image($this->getImage())
            ->actionLink($this->getUrl())
            ->actionText('View')
            ->toArray();
    }
}
