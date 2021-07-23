<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;
use App\Mail\MailNotify;
class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $message;
    protected $listEmail;
    protected $subject;
    public function __construct($listEmail,$subject,$message)
    {
        $this->message = $message;
        $this->listEmail = $listEmail;
        $this->subject = $subject;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->listEmail as $email) {
            if($email!=''){
                Mail::to($email)->send(new MailNotify($this->subject,$this->message));
            }

        }
    }
}
