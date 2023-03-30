<?php

namespace Modules\Livestream\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\Livestream\EpisodeDownload;

class EpisodeDownloadWasFailedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var EpisodeDownload
     */
    private $episodeDownload;

    /**
     * Create a new notification instance.
     *
     * @param EpisodeDownload $episodeDownload
     */
    public function __construct(EpisodeDownload $episodeDownload)
    {
        $this->episodeDownload = $episodeDownload;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('[Omnia Livestream] Your episodes download was failed!')
            ->greeting('Hi there,')
            ->line('Your episodes download was failed. Please try again or contact our support team.')
            ->line('Sorry for this inconvenient.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
