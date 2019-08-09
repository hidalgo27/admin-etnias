<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\App;
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
        if(App::isLocale('en')){
            $reservas='Reservations';
            $encuesta='Survey';
        }else{
            $reservas='Reservas';
            $encuesta='Encuesta';
        }

        $reserva=$this->reserva;
        return $this->view('admin.mail.encuestas.new',compact('reserva'))
        ->to($this->email)
        ->from('misreservas@mietnia.com',$reservas)
        ->subject($encuesta);
    }
}
