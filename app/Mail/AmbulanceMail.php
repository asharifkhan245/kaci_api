<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AmbulanceMail extends Mailable
{
    use Queueable, SerializesModels;




    public  $dependentname;
 public $map;
public $user;
public $ambulance;
public $image;
public $medication;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $user,$map, $dependentname,$ambulance,$image,$medication)
    {    
        $this->user=$user;
              $this->map=$map;
        $this->dependentname= $dependentname;
           $this->ambulance=$ambulance;
            $this->image=$image;
            $this->medication=$medication;
      
    
        
    }

    public function build()
    {
        return $this->subject('Ambulance Request'.' '.$this->ambulance['reference_code'])
                    ->view('emails.ambulanceMail');
    }



}
