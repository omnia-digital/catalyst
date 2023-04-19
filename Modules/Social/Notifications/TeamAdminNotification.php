<?php

namespace Modules\Social\Notifications;

use App\Models\Team;
use App\Support\Notification\NotificationCenter;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Trans;

class TeamAdminNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        private Team $team,
        private $message
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
        return ['mail', 'broadcast', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(Trans::get('You have a new message from the team: ' . $this->team->name))
            ->line(Trans::get('You have a new message from the team: ' . $this->team->name))
            ->line($this->message)
            ->action('View Team', $this->team->profile());
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $url = $this->team->profile();

        return NotificationCenter::make()
            ->icon('heroicon-o-user-group')
            ->info(Trans::get('You have a new message from the team: ' . $this->team->name))
            ->image($this->team->profile_photo_url)
            ->subtitle($this->message)
            ->actionLink($url)
            ->actionText('View')
            ->toArray();
    }
}
