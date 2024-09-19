<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

  public $sub;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($sub)
    {
        $this->sub=$sub;
      
    }

    public function build()
    {
        return $this->subject('Changed Password')
                    ->view('emails.adminPasswordMail');
    }
}
