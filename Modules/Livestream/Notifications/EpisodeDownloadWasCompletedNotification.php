<?php

namespace Modules\Livestream\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Modules\Livestream\EpisodeDownload;

class EpisodeDownloadWasCompletedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var EpisodeDownload
     */
    private $episodeDownload;

    /**
     * Create a new notification instance.
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
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('[Omnia Livestream] Your episodes are ready to download!')
            ->greeting('Hi there,')
            ->line('Your episodes are ready to download.')
            ->line('This link is only valid until ' . $this->episodeDownload->expires_at->format('l jS \of F Y h:i:s A') . '.')
            ->line('Please download as soon as possible.')
            ->action('Download Now', config('app.full_api_url') . '/' . $this->episodeDownload->download_path)
            ->line('Thank you for using our application!');
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
