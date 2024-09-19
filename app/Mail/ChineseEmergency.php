<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ChineseEmergency extends Mailable
{
    use Queueable, SerializesModels;

     public  $dependentname;
 public $map;
public $user;
public $ambulance;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $user,$map, $dependentname,$ambulance)
    {    
        $this->user=$user;
              $this->map=$map;
        $this->dependentname= $dependentname;
           $this->ambulance=$ambulance;
      
    
        
    }

    public function build()
    {
        return $this->subject('紧急情况'.' '.$this->ambulance['reference_code'])
                    ->view('emails.Chineseemergency');
    }
}
