<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Arabicfeedback extends Mailable
{
    use Queueable, SerializesModels;
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
        return $this->subject($this->feedback['reference_code'].' '.'تقرير الملاحظات')
                    ->view('emails.ArabicFk');
    }
}
