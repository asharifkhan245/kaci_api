<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class IgboCp extends Mailable
{
    use Queueable, SerializesModels;

 public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
   
        $this->user=$user;
    }

    public function build()
    {
        return $this->subject('Nwere Ebe Kweghi Akwukwo')
                    ->view('emails.Igbocp');
    }
}
