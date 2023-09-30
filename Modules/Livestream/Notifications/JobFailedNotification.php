<?php

namespace Modules\Livestream\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class JobFailedNotification extends Notification
{
    use Queueable;

    private $event;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($event)
    {
        $this->event = $event;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack'];
    }

    /**
     * Get the Slack representation of the notification.
     *
     * @param mixed $notifiable
     * @return SlackMessage
     */
    public function toSlack($notifiable)
    {
        $event_id = (!empty($this->event['id']) ? $this->event['id'] : null);
        $event_name = (!empty($this->event['name']) ? $this->event['name'] : null);
        Log::info('Sent slack notification for job #' . $event_id . ' for ' . $event_name);

        return (new SlackMessage)
            ->from(env('SLACK_ERRORS_USERNAME'))
            ->to(env('SLACK_ERRORS_CHANNEL'))
            ->image('SLACK_ERRORS_ICON')
            ->error()
            ->content('Queued job failed: ' . $this->event['job'])
            ->attachment(function ($attachment) use ($event_id, $event_name) {
                $attachment->title($this->event['exception']['message'])
                    ->fields([
                        'ID' => $event_id,
                        'Name' => $event_name,
                        'File' => $this->event['exception']['file'],
                        'Line' => $this->event['exception']['line'],
                        'Server' => env('APP_ENV'),
                        'Queue' => $this->event['queue'],
                    ]);
            });
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
