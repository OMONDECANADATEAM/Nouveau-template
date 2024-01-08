<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DepenseNotification extends Notification
{
    use Queueable;

    private $montant;
    private $agent;
    private $raison;

    /**
     * Create a new notification instance.
     *
     * @param float $montant
     * @param string $agent
     * @param string $raison
     */
    public function __construct(float $montant, string $agent, string $raison)
    {
        $this->montant = $montant;
        $this->agent = $agent;
        $this->raison = $raison;
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
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nouvelle Dépense')
            ->greeting('Bonjour,')
            ->line('Nouvelle dépense de ' . $this->montant . ' FCFA')
            ->line('par ' . $this->agent)
            ->line('pour la raison suivante : ' . $this->raison)
            ->salutation('Cordialement');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'montant' => $this->montant,
            'agent' => $this->agent,
            'raison' => $this->raison,
        ];
    }
}
