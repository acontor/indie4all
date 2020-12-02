<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class AceptarSolicitud extends Notification
{
    /**
     * The password reset token.
     *
     * @var string
     */
    public $url;
    public $name;
    public $admin;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($url, $name, $admin)
    {
        $this->url = $url;
        $this->name = $name;
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
            ->subject(Lang::get('Indie4all - Solicitud aceptada'))
            ->greeting('Hola ' . $this->name)
            ->line(Lang::get('Su solicitud ha sido aceptada. Ya puede acceder a su panel de administración para empezar a administrar su perfil.'))
            ->action(Lang::get('Accede al panel'), $this->url)
            ->salutation('Le saluda cordialmente, ' . $this->admin . '.');
    }
}
