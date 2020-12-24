<?php

namespace App\Mail\Sorteos;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SorteoGanador extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $sorteo;
    public $desarrolladora;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $sorteo, $desarrolladora)
    {
        $this->name = $name;
        $this->sorteo = $sorteo;
        $this->desarrolladora = $desarrolladora;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('soporte@indie4all.com')
            ->subject('Indie4all - Ganador Sorteo')
            ->view('emails.sorteos.ganador')
            ->with([
                'name' => $this->name,
                'sorteo' => $this->sorteo,
                'desarrolladora' => $this->desarrolladora,
            ]);
    }
}
