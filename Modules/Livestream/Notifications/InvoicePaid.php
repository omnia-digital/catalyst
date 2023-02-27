<?php

namespace Modules\Livestream\Notifications;

use Modules\Livestream\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Laravel\Cashier\Invoice;
use Laravel\Spark\Spark;
use Stripe\Stripe;

class InvoicePaid extends Notification
{
    use Queueable;
    protected $billable;
    protected $invoice;

    /**
     * Create a new notification instance.
     *
     * @param mixed $billable
     * @param Invoice $invoice
     */
    public function __construct($billable, Invoice $invoice)
    {
        $this->billable = $billable;
        $this->invoice = $invoice;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $invoiceData = Spark::invoiceDataFor($this->billable);
        $mailMessage = (new MailMessage)->subject($invoiceData['product'] . ' Invoice')
            ->greeting('Hi ' . ($this->billable instanceof User ? explode(' ', $this->billable->name)[0] : $this->billable->name )  . '!')
            ->line('Thanks for your continued support. We\'ve attached a copy of your invoice for your records. Please let us know if you have any questions or concerns!')
            ->attachData($this->invoice->pdf($invoiceData), 'invoice.pdf');
        return $mailMessage;
    }
}