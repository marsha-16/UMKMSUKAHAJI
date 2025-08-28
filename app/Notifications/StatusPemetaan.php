<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StatusPemetaan extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        protected $pemetaan,
        protected $oldStatus,
        protected $newStatus
    )
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'pemetaan_id' => $this->pemetaan->id,
            'name' => $this->pemetaan->name,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
            'message' =>"Status Pemetaan UMKM '{$this->pemetaan->name}' berubah dari {$this->oldStatus} menjadi {$this->newStatus}.",
        ];
    }
}
