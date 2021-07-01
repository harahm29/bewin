<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Voucher extends Mailable
{
    use Queueable, SerializesModels;
	public $voucherGenerates;
	public $voucherGeneratedetails;
	public $subject;
	
	
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($voucherGenerates,$voucherGeneratedetails,$subject)
    {
        // print_r($voucherGenerates); exit;
		$this->voucherGenerates = $voucherGenerates;
		$this->voucherGeneratedetails = $voucherGeneratedetails;
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
        ->view('mail.voucher');
    }
}
