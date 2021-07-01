<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use mail;
use Auth;
use DB;
use App\Lottery;
use App\Mail\Usermail;
class LotteryDraw extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'word:day';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Email to All User';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
		Lottery::update(['status'=>0]);
		$this->send_user_email("trilok@peninftech.com","Cron Job Test","Test","Test");
			$this->send_user_email("trilokkumar970@gmail.com","Cron Job Test","Test","Test");
    }
	public function send_user_email($email,$msg,$name,$subject)
	{
		Mail::to($email)
		->send(new Usermail($msg,$name,$subject));
	}
}
