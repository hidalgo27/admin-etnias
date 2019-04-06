<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailSenderOtros extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $asociacion;
    public $email;
    
    public function __construct($p_asociacion,$email)
    {
        //
        $this->asociacion=$p_asociacion;
        $this->email=$email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->view('view.name');
        return $this->view('admin.mail.otros.new')
            ->to($this->email)
            ->from('etniasworker@mietnias.com','Team etnias')
            ->subject('Bienvienido etniasworker');
    }
}
