<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class hausafeedback extends Mailable
{
   public $feedback;
public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($feedback,$user)
    {
        $this->feedback=$feedback;
        $this->user=$user;
    }

    public function build()
    {
        return $this->subject('Rumbun Bayani na Tambaya'.' '.$this->feedback['reference_code'])
                    ->view('emails.HausaFk');
    }
}
