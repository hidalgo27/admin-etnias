<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailSenderEncuesta extends Mailable
{
    use Queueable, SerializesModels;
    public $reserva;
    public $email;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($preserva,$pemail)
    {
        //
        $this->reserva=$preserva;
        $this->email=$pemail;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $reserva=$this->reserva;
        return $this->view('admin.mail.encuestas.new',compact('reserva'))
        ->to($this->email)
        ->from('misreservas@mietnia.com','Reservas')
        ->subject('Encuesta');
    }
}
