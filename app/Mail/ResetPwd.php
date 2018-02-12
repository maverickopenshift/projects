<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPwd extends Mailable
{
    use Queueable, SerializesModels;

    public $nama_perusahaan;
    public $sendTo;
    public $random_pwd;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($random_pwd,$nama_perusahaan,$sendTo, $subject)
    {
        $this->nama_perusahaan = $nama_perusahaan;
        $this->sendTo = $sendTo;
        $this->random_pwd = $random_pwd;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('usersupplier::ResetPass')->subject($this->subject);
    }
}
