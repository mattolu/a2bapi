<?php
namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;


class PasswordDriverReset extends Notification
{

    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Password Reset')
            ->line('You are receiving this email because we received a password reset request for your account.') // Here are the lines you can safely override
            ->action('Reset Password', url('driverreset', $this->token))
            // ->action(Lang::getFromJson('Reset Password'), url('password.reset', $this->token, false))
            ->line('If you did not request a password reset, no further action is required.');
    }
}