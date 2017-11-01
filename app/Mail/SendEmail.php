<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $mail_message;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mail_message, $subject)
    {
        $this->mail_message = $mail_message;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('usersupplier::notifEmail')->subject($this->subject);
    }
}
