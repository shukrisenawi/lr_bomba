<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

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
        return (new MailMessage)
            ->view('emails.auth.reset')
            ->subject('Pemberitahuan Reset Kata Laluan')
            ->with([
                'introLines' => ['Anda menerima e-mel ini kerana kami menerima permintaan reset kata laluan untuk akaun anda.'],
                'actionText' => 'Reset Kata Laluan',
                'actionUrl' => url('/reset-password/' . $this->token),
                'outroLines' => [
                    'Pautan reset kata laluan ini akan tamat tempoh dalam 60 minit.',
                    'Jika anda tidak meminta reset kata laluan, tiada tindakan lanjut diperlukan.'
                ]
            ]);
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
