<?php

namespace Modules\Social\Notifications;

use App\Models\Team;
use App\Models\User;
use App\Support\Notification\NotificationCenter;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Trans;

class NewMemberOfMyTeamNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        private Team $team,
        private User $newMember
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
        if ($notifiable->id === $this->newMember->id) {
            return [];
        }

        return ['broadcast', 'database', 'mail'];
    }

    public function getTitle()
    {
        return $this->getMessage();
    }

    public function getMessage()
    {
        return Trans::get($this->newMember->name . ' has been added to the team, ' . $this->team->name);
    }

    public function getUrl()
    {
        return $this->team->profile() ?? route('notifications');
    }

    public function getImage()
    {
        return $this->newMember->profile_photo_url;
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

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return NotificationCenter::make()
            ->icon('heroicon-o-user')
            ->success($this->getMessage())
            ->image($this->getImage())
            ->actionLink($this->getUrl())
            ->actionText('View')
            ->toArray();
    }
}
