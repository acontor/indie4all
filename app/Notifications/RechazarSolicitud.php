<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RechazarSolicitud extends Notification
{
    /**
     * The password reset token.
     *
     * @var string
     */
    public $name;
    public $motivo;
    public $admin;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($name, $motivo, $admin)
    {
        $this->name = $name;
        $this->motivo = $motivo;
        $this->admin = $admin;
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
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
            ->subject('Indie4all - Solicitud rechazara')
            ->greeting('Hola ' . $this->name)
            ->line('Su solicitud ha sido rechazada por los siguientes motivos:')
            ->line($this->motivo)
            ->line('Puedes ponerte en contacto con nosotros para saber más.')
            ->salutation('Le saluda cordialmente, ' . $this->admin . '.');
    }
}
