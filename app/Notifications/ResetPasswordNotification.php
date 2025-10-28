<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Mail\Mailable;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    public $token;

    /**
     * Create a new notification instance.
     */
    public function __construct($token)
    {
        $this->token = $token;
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
        $mail = (new MailMessage)
            ->subject('Pemberitahuan Reset Kata Laluan')
            ->greeting('Hello!')
            ->line('Anda menerima e-mel ini kerana kami menerima permintaan reset kata laluan untuk akaun anda.')
            ->action('Reset Kata Laluan', url('/reset-password/' . $this->token))
            ->line('Pautan reset kata laluan ini akan tamat tempoh dalam 60 minit.')
            ->line('Jika anda tidak meminta reset kata laluan, tiada tindakan lanjut diperlukan.')
            ->view('emails.auth.reset');

        // Add anti-spam headers using callback
        $mail->withSymfonyMessage(function ($message) {
            $message->getHeaders()
                ->addTextHeader('X-Mailer', 'Sistemftwupm')
                ->addTextHeader('List-Unsubscribe', '<mailto:unsubscribe@multivita2u.com>');
        });

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
            //
        ];
    }
}
