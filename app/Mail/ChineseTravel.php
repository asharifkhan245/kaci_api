<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ChineseTravel extends Mailable
{
    use Queueable, SerializesModels;

  
    public  $dependentname;
 public $map;
public $user;
public $travel;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $user,$map, $dependentname,$travel)
    {    
        $this->user=$user;
              $this->map=$map;
        $this->dependentname= $dependentname;
           $this->travel=$travel;
      
    
        
    }

    public function build()
    {
        return $this->subject('TravelSafe Request '.' '.$this->travel['reference_code'])
                    ->view('emails.Chinesetravel');
    }
}
