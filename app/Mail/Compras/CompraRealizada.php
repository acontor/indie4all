<?php

namespace App\Mail\Compras;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompraRealizada extends Mailable
{
    use Queueable, SerializesModels;

    public $key;
    public $name;
    public $mensaje;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($key, $name, $mensaje)
    {
        $this->key = $key;
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
            ->subject('Indie4all - Compra Realizada')
            ->view('emails.compras.compra')
            ->with([
                'key' => $this->key,
                'name' => $this->name,
                'mensaje' => $this->mensaje,
            ]);
    }
}
