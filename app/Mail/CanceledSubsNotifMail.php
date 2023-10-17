<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CanceledSubsNotifMail extends Mailable
{
    use Queueable, SerializesModels;


    public $company;
    public $date;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($company, $date)
    {
        $this->company = $company;
        $this->date = $date;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject($this->company . ' canceled subscription.')
            ->from(config('mail.from.address'))
            ->view('emails.canceled_subscription', ['date' => $this->date]);
    }
}
