<?php

namespace App\Mail;

use App\Models\Participante;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistroCarreraMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Participante $participante
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirmación de registro - 1ra Carrera Atlética del Educador Físico',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.registro-carrera',
        );
    }
}