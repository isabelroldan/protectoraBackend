<?php

namespace App\Mail;

use App\Models\SolicitudDeAdopcion;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CambioEstadoSolicitud extends Mailable
{
    use Queueable, SerializesModels;

    public $solicitud;

    public function __construct(SolicitudDeAdopcion $solicitud)
    {
        $this->solicitud = $solicitud;
    }

    public function build()
    {
        return $this->subject('Cambio en el estado de tu solicitud de adopción')
                    ->view('emails.cambio_estado', ['solicitud', $this->solicitud]);
    }
}

