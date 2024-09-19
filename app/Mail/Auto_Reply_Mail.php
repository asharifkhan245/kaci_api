<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Auto_Reply_Mail extends Mailable
{
    use Queueable, SerializesModels;

   public $user;
public $response;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$response)
    {
        $this->user=$user;
        $this->response=$response;
    }

    public function build()
    {
        return $this->subject('KACI')
                    ->view('emails.auto_reply');
    }
}
