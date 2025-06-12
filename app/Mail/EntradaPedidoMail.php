<?php

namespace App\Mail;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EntradaPedidoMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $pedido;
    protected $infoPelicula;
    protected $butacas;
    protected $usuario;
    protected $qrCode;

    /**
    * Create a new message instance.
    */
    public function __construct($pedido, $infoPelicula, $butacas, $usuario, $qrCode)
    {
        $this->pedido = $pedido;
        $this->infoPelicula = $infoPelicula;
        $this->butacas = $butacas;
        $this->usuario = $usuario;
        $this->qrCode = $qrCode;
    }

    /**
    * Build the message.
    */
    public function build()
    {
        $pdf = Pdf::loadView('pdf.entrada', [
            'pedido' => $this->pedido,
            'infoPelicula' => $this->infoPelicula,
            'butacas' => $this->butacas,
            'usuario' => $this->usuario,
            'qrCode' => $this->qrCode,
        ]);

        return $this->subject('Tu entrada de cine')
            ->view('emails.contenidoCorreo', [
                'pedido' => $this->pedido,
                'infoPelicula' => $this->infoPelicula
            ])
            ->attachData($pdf->output(), 'entrada.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
