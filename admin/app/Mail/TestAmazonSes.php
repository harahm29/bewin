<?php

namespace App\Mail;
use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TestAmazonSes extends Mailable
{
    use Queueable, SerializesModels;
    
    public $email_content;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email_content)
    {
        $this->email_content = $email_content;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@b2studies.com')->view('mail.tpl');
    }
}