<?php

namespace App\Mail\Compras;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InversionRealizada extends Mailable
{
    use Queueable, SerializesModels;

    public $precio;
    public $name;
    public $mensaje;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($precio, $name, $mensaje)
    {
        $this->precio = $precio;
        $this->name = $name;
        $this->mensaje = $mensaje;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('ventas@indie4all.com')
            ->subject('Indie4all - Inversión Realizada')
            ->view('emails.compras.inversion')
            ->with([
                'precio' => $this->precio,
                'name' => $this->name,
                'mensaje' => $this->mensaje,
            ]);;
    }
}
