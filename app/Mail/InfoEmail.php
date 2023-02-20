<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InfoEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $mailData;
    public $res;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailData, $res)
    {
        $this->mailData = $mailData;
        $this->res =$res;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Update Status Request')->markdown('emails.infoEmail');
    }
}
