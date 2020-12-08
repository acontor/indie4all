<?php

namespace App\Mail\Sorteos;

use App\Models\Sorteo;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SorteoConfirmacion extends Mailable
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
    public function __construct($name, Sorteo $sorteo, $desarrolladora)
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
            ->subject('Indie4all - Confirmación Sorteo')
            ->view('emails.sorteos.confirmacion')
            ->with([
                'name' => $this->name,
                'desarrolladora' => $this->desarrolladora,
                'sorteo' => $this->sorteo,
            ]);
    }
}
