<?php

namespace App\Mail\Solicitudes;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RechazarSolicitud extends Mailable
{
    use Queueable, SerializesModels;

    public $motivo;
    public $name;
    public $admin;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($motivo, $name, $admin)
    {
        $this->motivo = $motivo;
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
            ->subject('Indie4all - Solicitud Rechazada')
            ->view('emails.solicitudes.rechazada')
            ->with([
                'motivo' => $this->motivo,
                'name' => $this->name,
                'admin' => $this->admin,
            ]);
    }
}
