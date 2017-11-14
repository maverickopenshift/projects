<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailUser extends Mailable
{
    use Queueable, SerializesModels;

    public $email_password;
    public $email_username;
    public $subject;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email_password, $email_username, $subject)
    {
      $this->email_password = $email_password;
      $this->email_username = $email_username;
      $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('users::EmailPassword')->subject($this->subject);
    }
}
