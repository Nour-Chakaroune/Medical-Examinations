<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReturnedReqEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $mailData;
    public $reason;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailData, $reason)
    {
        $this->mailData = $mailData;
        $this->reason =$reason;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Update Status Request')->markdown('emails.returnedreqEmail');
    }
}
