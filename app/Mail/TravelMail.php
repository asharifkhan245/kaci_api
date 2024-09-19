<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TravelMail extends Mailable
{
    use Queueable, SerializesModels;

  public $dependant;
  public $ambulance;
public $user;
public $latitude;
public $longitude;
public $image;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $user,$ambulance,$dependant,$latitude,$longitude,$image)
    {    
        $this->user=$user;
         $this->ambulance=$ambulance;
        $this->dependant=$dependant;
          $this->latitude=$latitude;
           $this->longitude=$longitude;
            $this->image=$image;
    
        
    }

    public function build()
    {
        return $this->subject('Travel Safe Request'.' '.$this->ambulance['reference_code'])
                    ->view('emails.travelMail');
    }
}
