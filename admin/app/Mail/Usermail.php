<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserMail extends Mailable
{
    use Queueable, SerializesModels;
	public $order;
	public $name;
	public $subject;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order,$name,$subject)
    {
        //
		$this->order = $order;
		$this->name = $name;
		$this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
		return $this->subject($this->subject)
        ->view('mail.email');
    }
}
