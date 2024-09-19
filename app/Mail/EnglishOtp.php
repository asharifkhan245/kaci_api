<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EnglishOtp extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $token;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$token)
    {
        $this->user=$user;
        $this->token=$token;
    }

    public function build()
    {
        return $this->subject('Email Address Update')
                    ->view('emails.EnglishOtpMail');
    }
}
