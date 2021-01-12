<?php

namespace App\Mail\Actualizaciones;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CorreoDiario extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $postsJuegos;
    public $postsDesarrolladoras;
    public $postsMasters;
    public $estrenos;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $postsJuegos, $postsDesarrolladoras, $postsMasters, $estrenos)
    {
        $this->name = $name;
        $this->postsJuegos = $postsJuegos;
        $this->postsDesarrolladoras = $postsDesarrolladoras;
        $this->postsMasters = $postsMasters;
        $this->estrenos = $estrenos;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('actualizaciones@indie4all.com')
            ->subject('Indie4all - Resumen diario')
            ->view('emails.actualizaciones.diaria')
            ->with([
                'name' => $this->name,
                'postsJuegos' => $this->postsJuegos,
                'postsDesarrolladoras' => $this->postsDesarrolladoras,
                'postsMasters' => $this->postsMasters,
                'estrenos' => $this->estrenos,
            ]);
    }
}
