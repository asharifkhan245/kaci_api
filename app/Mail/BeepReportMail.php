<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BeepReportMail extends Mailable
{
    use Queueable, SerializesModels;

 
    public $notifyUser;
    public $user;
    public $reportItem;
    public $reportreason;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $notifyUser,$user,$reportItem , $reportreason)
    {    
        $this->user=$user;
        $this->notifyUser = $notifyUser;
        $this->reportItem = $reportItem;
        $this->reportreason = $reportreason;
            

        
    }

    public function build()
    {
        return $this->subject('Beep Report')
                    ->view('emails.reportbeepmail');
    }

}
