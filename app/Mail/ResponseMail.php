<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResponseMail extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $response;
    public $title;
    public  $response_Image;
        /**
         * 
         * Create a new message instance.
         *
         * @return void
         */
        public function __construct($user, $response , $title , $response_Image)
        {
            $this->user = $user;
            $this->response= $response;
            $this->title=$title;
            $this->response_Image=$response_Image;
        }
    
        public function build()
        {
            return $this->subject($this->title)
                        ->view('emails.responsemail');
        }
    }

