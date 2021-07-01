<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PaymentInvoice extends Mailable
{
    use Queueable, SerializesModels;
	public $pdf;
	public $name;
	public $subject;
	public $payment;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pdf,$name,$subject,$payment)
    {
        //
		$this->pdf = $pdf;
		$this->name = $name;
		$this->subject = $subject;
		$this->payment = $payment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
			->attachData($this->pdf, "invoice.pdf")
			->view('mail.paymentInvoice');
    }
}
