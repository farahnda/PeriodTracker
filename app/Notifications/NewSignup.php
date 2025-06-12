<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
// use Pest\ArchPresets\Strict;
// use Str;

class NewSignup extends Notification 
// implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public string $name, public string $email)
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
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Selamat Datang di Period Tracker!")
            ->line("Akun dengan email {$this->email} telah berhasil didaftarkan.")
            ->action('Masuk Sekarang', url('/login'))
            ->line("Terima kasih {$this->name} sudah menggunakan website kami!");
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

    public function toDatabase($notifiable): array
    {
        return [
            'title' => 'Pengguna Baru Terdaftar',
            'body' => "{$this->name} ({$this->email}) telah mendaftar.",
            'url' => url('/users'), // arahkan ke daftar user, opsional
        ];
    }
}
