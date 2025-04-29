<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotificationEmail extends Notification implements ShouldQueue
{
    use Queueable;

    protected $message;
    protected $bookTitle;
    protected $actionUrl;
    protected $actionText;

    /**
     * Create a new notification instance.
     */
    public function __construct($message, $bookTitle = null, $actionUrl = '/home', $actionText = 'Voir les détails')
    {
        $this->message = $message;
        $this->bookTitle = $bookTitle;
        $this->actionUrl = $actionUrl;
        $this->actionText = $actionText;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database']; // Envoi par email et sauvegarde en base
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->greeting('Bonjour ' . $notifiable->first_name . ' ' . $notifiable->last_name . '!');

        if ($this->bookTitle) {
            $mail->line("Livre concerné : " . $this->bookTitle);
        }

        return $mail
            ->line($this->message)
            ->action($this->actionText, url($this->actionUrl))
            ->line('Merci d\'utiliser notre bibliothèque!')
            ->salutation('Cordialement, l\'équipe de la bibliothèque');
    }

    /**
     * Get the array representation for database storage.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => $this->message,
            'book_title' => $this->bookTitle,
            'action_url' => $this->actionUrl,
            'read_at' => null,
        ];
    }
}
