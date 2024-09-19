<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SuggestionMail extends Mailable
{
    use Queueable, SerializesModels;

   
    public  $dependentname;
 
public $user;
public $ambulance;
public $image;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $user,$dependentname,$ambulance,$image)
    {    
        $this->user=$user;
            
        $this->dependentname= $dependentname;
           $this->ambulance=$ambulance;
            $this->image=$image;
      
    
        
    }

    public function build()
    {
        return $this->subject('Suggestion Request'.' '.$this->ambulance['reference_code'])
                    ->view('emails.suggestion');
    }

}
