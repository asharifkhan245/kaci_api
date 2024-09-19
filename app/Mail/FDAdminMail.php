<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FDAdminMail extends Mailable
{
    use Queueable, SerializesModels;

     public  $dependentname;
 
public $user;
public $feedback;
public $image;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $user,$dependentname, $feedback,$image)
    {    
        $this->user=$user;
            
        $this->dependentname= $dependentname;
           $this->feedback=$feedback;
            $this->image=$image;
      
    
        
    }

    public function build()
    {
        return $this->subject('Feedback Request'.' '.$this->feedback['reference_code'])
                    ->view('emails.fdadmin');
    }


    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
