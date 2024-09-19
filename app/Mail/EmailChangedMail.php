<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailChangedMail extends Mailable
{
     use Queueable, SerializesModels;

public $user;
public $subject;
public $response;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$subject,$response)
    {
   
        $this->user=$user;
          $this->subject=$subject;
            $this->response=$response;
    }

    public function build()
    {
        return $this->subject($this->subject)
                    ->view('emails.emailchangedmail');
    }
}
