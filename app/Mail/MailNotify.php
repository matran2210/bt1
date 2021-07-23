<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailNotify extends Mailable
{
    use Queueable, SerializesModels;

    public $message;
    public $subject;
    /**
     * Create a new data instance.
     *
     * @return void
     */

    public function __construct($subject,$message)
    {
        $this->message = $message;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = $this->message;
        return $this->from('doancuongB10@gmail.com')
            ->view('user.mail-notify',compact('data'))
            ->subject($this->subject);
    }
}