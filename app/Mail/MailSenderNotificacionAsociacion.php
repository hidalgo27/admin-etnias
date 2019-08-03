<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailSenderNotificacionAsociacion extends Mailable
{
    use Queueable, SerializesModels;
    public $asociacion_nombre;
    public $servicio_tipo;
    public $servicio_nombre;
    public $email;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($asociacion_nombre,$servicio_tipo,$servicio_nombre,$email)
    {
        //
        $this->asociacion_nombre=$asociacion_nombre;
        $this->servicio_tipo=$servicio_tipo;
        $this->servicio_nombre=$servicio_nombre;
        $this->email=$email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('admin.mail.asociacion.notificacion-admin',['asociacion_nombre'=>$this->asociacion_nombre,'servicio_tipo'=>$this->servicio_tipo,'servicio_nombre'=>$this->servicio_nombre])
        ->to($this->email)
        ->from('misreservas@mietnia.com','Sistema')
        ->subject('Aprobar cambios');
    }
}
