<?php

namespace App\Mail;
use Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PDF;
class EmployeeEmail extends Mailable
{
    use Queueable, SerializesModels;


  
    public function __construct()
    {
        
    }

   
    public function build()
    {
        
    }
}
