<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NoPredictionInputNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
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
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('Input Data Sekarang!')
            ->line('Anda belum mengisi prediksi menstruasi lebih dari 1 bulan.')
            ->action('Mulai Prediksi', url('/calendars/create'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

    public function toDatabase($notifiable) {
        return [
            'title' => 'Belum Input Data',
            'body' => 'Anda belum mengisi prediksi menstruasi lebih dari 1 bulan.',
            'url' => url('/calendars/create'),
        ];
    }
}
