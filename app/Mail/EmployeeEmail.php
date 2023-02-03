<?php

namespace App\Mail;
use Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PDF;
use Config;
use App\MailInvitation;

class EmployeeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $mail_invitation;

    public function __construct(MailInvitation $mail_invitation)
    {
       $this->mail_invitation = $mail_invitation;
    }

   
    public function build()
    {

        return $this->from(Config::get('mail.from.address'))->subject('Mail Activation')->view('emails.activation');
    }
}
