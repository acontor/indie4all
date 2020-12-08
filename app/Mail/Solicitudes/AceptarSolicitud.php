<?php

namespace App\Mail\Solicitudes;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AceptarSolicitud extends Mailable
{
    use Queueable, SerializesModels;

    public $url;
    public $name;
    public $admin;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($url, $name, $admin)
    {
        $this->url = $url;
        $this->name = $name;
        $this->admin = $admin;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('soporte@indie4all.com')
            ->subject('Indie4all - Solicitud Aceptada')
            ->view('emails.solicitudes.aceptada')
            ->with([
                'url' => $this->url,
                'name' => $this->name,
                'admin' => $this->admin,
            ]);
    }
}
