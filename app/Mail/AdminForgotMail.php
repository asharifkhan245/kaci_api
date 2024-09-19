<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminForgotMail extends Mailable
{
    use Queueable, SerializesModels;

public $sub;
public $token;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($sub,$token)
    {
        $this->sub=$sub;
        $this->token=$token;
    }

    public function build()
    {
        return $this->subject('Forgot Password OTP')
                    ->view('emails.adminForgot');
    }
}
