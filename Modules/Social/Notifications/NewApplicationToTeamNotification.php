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

class NewApplicationToTeamNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        private Team $team,
        private User $applicant
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
        return ['broadcast', 'database', 'mail'];
    }

    public function getTitle()
    {
        return Trans::get($this->applicant->name . ' applied to your team, ' . $this->team->name);
    }

    public function getSubTitle()
    {
        return '';
    }

    public function getMessage()
    {
        return Trans::get('Your application to ' . $this->team->name . ' has been accepted');
    }

    public function getUrl()
    {
        return $this->team->profile() ?? route('notifications');
    }

    public function getImage()
    {
        return $this->applicant->profile_photo_url;
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
    public function toArray($notifiable): array
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
