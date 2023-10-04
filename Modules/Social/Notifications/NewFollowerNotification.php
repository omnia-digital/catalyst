<?php

namespace Modules\Social\Notifications;

use App\Models\User;
use App\Notifications\BaseNotification;
use App\Support\Notification\NotificationCenter;
use Illuminate\Notifications\Messages\MailMessage;
use OmniaDigital\CatalystCore\Facades\Translate;

class NewFollowerNotification extends BaseNotification
{
    public function __construct(
        private User $follower
    ) {
    }

    public function via($notifiable): array
    {
        if ($notifiable->id === $this->follower->id) {
            return [];
        }

        return static::getChannels();
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

    public function getTitle()
    {
        return Translate::get('You have a new follower');
    }

    public function getMessage()
    {
        return $this->follower->name . Translate::get(' followed you');
    }

    public function getUrl()
    {
        return $this->follower->url() ?? route('notifications');
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

    public function getImage()
    {
        return $this->follower->profile_photo_url;
    }
}
