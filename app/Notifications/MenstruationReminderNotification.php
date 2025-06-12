<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
    
class MenstruationReminderNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

    protected $type;
    protected $title;
    protected $body;

    public function __construct($type = 'reminder', $title = null, $body = null)
    {
        $this->type = $type;
        $this->title = $title;
        $this->body = $body;
    }


    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
        public function toMail(object $notifiable): MailMessage
    {
        $mail = new MailMessage;

        if ($this->type === 'day_H') {
            $mail->line("Hari ini adalah hari pertama menstruasimu.")
                 ->line("Jangan lupa jaga kesehatan ya!");
        } elseif ($this->type === 'H-3') {
            $mail->line("Menstruasi akan datang dalam 3 hari lagi.")
                 ->line("Persiapkan kebutuhanmu.");
        } elseif ($this->type === 'article') {
            $mail->line("Artikel Baru: {$this->title}")
                 ->line($this->body)
                 ->action('Baca Sekarang', url('/articles')); // contoh link
        } else {
            $mail->line("Ini adalah pengingat dari Period Tracker.");
        }

        return $mail;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => $this->type,
            'title' => $this->title,
            'body' => $this->body,
        ];
    }
}
