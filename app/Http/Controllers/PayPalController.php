<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\ExpressCheckout;
use App\Lottery;
use App\User;
use App\Order;
use App\Transaction;
use App\AddLotteryTicket;
use Auth;
use DB;
use Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\Usermail;
use DateTime;
class PayPalController extends Controller
{
    //
	public function create(Request $request)
	{
		return view('paypal.create');
	}
	public function lottery_summary(Request $request,$id)
	{
		if(Auth::check() && Auth::user()->type=='agent')
		{
			return redirect('/');
		}
		else
		{
		$lottery = $this->get_lottery($id);
		$wallet  = $this->check_uses_wallet();
		$balance = session('total_price') - $wallet;
		session(['balance'=>$balance]);
		return view('paypal.lottery-summary',compact('wallet','lottery'));
		}
	}
	private function add_lottery_ticket($lottery_info,$lottery_no,$power_ball_no,$status,$lottery_type,$ticket_no,$total_price,$free_play_id)
	{
		//echo $lottery_no;exit;
		$draw_array = $this->get_lottery_next_draw_date_and_time($lottery_info->id);
		$draw_day  = $draw_array["day"];
		$add_lottery_ticket = new AddLotteryTicket;
		$add_lottery_ticket->user_id = Auth::user()->id;
		$add_lottery_ticket->lottery_id = $lottery_info->id;
		$add_lottery_ticket->lottery_name = $lottery_info->name;
		$add_lottery_ticket->lottery_price = $lottery_info->ticket_price;
		$add_lottery_ticket->lottery_no = $lottery_no ?? 0;
		$add_lottery_ticket->power_ball_no = $power_ball_no ?? 0;
		$add_lottery_ticket->today_date = date("Y-m-d");
		$add_lottery_ticket->status = $status;
		$add_lottery_ticket->lottery_type = $lottery_type;
		$add_lottery_ticket->ticket_no = $ticket_no;
		$add_lottery_ticket->total_price = $total_price;
		$add_lottery_ticket->free_play_id = $free_play_id;
		$add_lottery_ticket->draw_date_time = date("d M Y h:i:s",strtotime("$draw_day $lottery_info->draw_timing"));
		$add_lottery_ticket->save();
		
		
		return $add_lottery_ticket->id;
	}
	private function check_uses_wallet()
	{
		$transaction = DB::table('transactions as B')
								->select([DB::raw("sum(B.dr) as total_dr"),DB::raw("sum(B.cr) as total_cr")])
								->where(['B.is_deleted'=>0,'user_id'=>Auth::user()->id])
								//->groupBy(['B.id'])
								->first();		
		$wallet = $transaction->total_cr - $transaction->total_dr;
								//echo "<pre>";
								//print_r($transaction);exit;@endphp
								
		return $wallet;						
	}
	private function generateCode($limit)
	{
		
		$a=array("01"=>"01","02"=>"02","03"=>"03","04"=>"04","05"=>"05","06"=>"06","07"=>"07","08"=>"08","09"=>"09","10"=>"10","11"=>"11","12"=>"12","13"=>"13","14"=>"14","15"=>"15","16"=>"16","17"=>"17","18"=>"18","19"=>"19","20"=>"20","21"=>"21","22"=>"22","23"=>"23","24"=>"24","25"=>"25","26"=>"26","27"=>"27","28"=>"28","29"=>"29","30"=>"30","31"=>"31","32"=>"32","33"=>"33","34"=>"34","35"=>"35","36"=>"36","37"=>"37","38"=>"38","39"=>"39","40"=>"40","41"=>"41","42"=>"42","43"=>"43","44"=>"44","45"=>"45","46"=>"46","47"=>"47","48"=>"48","49"=>"49","50"=>"50");
       return $random_array = (array_rand($a,$limit));

	}
	private function generateCodePowerball($limit)
	{
		
		$a=array("01"=>"01","02"=>"02","03"=>"03","04"=>"04","05"=>"05","06"=>"06","07"=>"07","08"=>"08","09"=>"09","10"=>"10","11"=>"11","12"=>"12","13"=>"13","14"=>"14","15"=>"15","16"=>"16","17"=>"17","18"=>"18","19"=>"19","20"=>"20","21"=>"21","22"=>"22","23"=>"23","24"=>"24","25"=>"25");
       return $random_array = (array_rand($a,$limit));
	}
	function get_day_val($lottery_days,$start_time,$end_time)
	{
		// echo "<pre>";
						// print_r($lottery_days);
						$check_status = 0;
						$response = 0;
						// created by 
					$start_time = date("Y-m-d H:s:i",strtotime($start_time));
					$end_time = date("Y-m-d H:s:i",strtotime($end_time));
						
						$weekNo = date('Y-m-d H:s:i');
						 // $lottery_days =["Monday", "Tuesday","Saturday"]; 
						  /*  check today lottery */ 
						  
						  $today_lottery_day = date('l', strtotime($weekNo));
						 if(in_array($today_lottery_day,$lottery_days)){
								// echo 'today lottry day</br>';	
								if($weekNo<$end_time){
									// echo 'time less';
									$check_status = 1;
									$response = $weekNo;
								}
								else{
									// echo "time greater";
								}
								
							}
						 /*  check today lottery */ 
						 if($check_status==0)
						 {
						   /*  check next lottery  date*/ 
							$select_week_day = '';
						 for($i=1;$i<8;$i++){
							$select_week_day = date("l", strtotime("+$i day"));
							if(in_array($select_week_day,$lottery_days)){
								break;
							}
							
						 }
						 						$nextLotteryDate= strtotime("next $select_week_day");
												$response = date('Y-m-d', $nextLotteryDate);
												
						 }


						return date("d M Y",strtotime($response));
						   /*  check next lottery  date*/
	}
	public function get_lottery_next_draw_date_and_time($id)
	{
		$lottery= $this->get_lottery($id);
		$draw_days_array = explode(",",$lottery->draw_days);
		$current_time = date("h a");
		$timeSlotStart = DB::table("time_slots")->where(['id'=>$lottery->start_lottery_time])->first();
		$start_time = $timeSlotStart->name;
		$timeSlot = DB::table("time_slots")->where(['id'=>$lottery->end_lottery_time])->first();
		$end_time = $timeSlot->name;
		$lottery_date = $this->get_day_val($draw_days_array,$start_time,$end_time);
									
		$time1 = DateTime::createFromFormat('H a', $current_time);
		// print_r($time1);
		// exit;
		$time2 = DateTime::createFromFormat('H a', $start_time);
		$time3 = DateTime::createFromFormat('H a', $end_time);
									
		$day_status = 0;
		$weekNo_day = date('Y-m-d H:s:i');
		$today_lottery_day = date('l', strtotime($weekNo_day));
		if(in_array($today_lottery_day,$draw_days_array)){
											
		$day_status = 1;
											
										
		}
		if($day_status==1 && ($time1 >= $time3) && ($time1 <= $time2))
		{
			$time_status = 1;
		}
		else
			$time_status = 0;
		
		return $array = array("day"=>$lottery_date,"time_status"=>$time_status);
		
	}
	function get_user_free_ticket_val($lottery_id,$draw_date,$draw_time)
	{
		if(Auth::check())
			$user_id = Auth::user()->id;
		else
			$user_id = 0;
		$draw_date_time = $draw_time;
		$free_ticket = DB::table('user_free_tickets')
							->where(['user_id'=>$user_id,
									  'draw_date'=>$draw_date,
									  'lottery_id'=>$lottery_id,
									  'status'=>0
									  ])
							->where('draw_date_time','=',$draw_date_time)
							->first();
		$free_ticket_count = DB::table('user_free_tickets')
							->where(['user_id'=>$user_id,
									  'draw_date'=>$draw_date,
									  'lottery_id'=>$lottery_id,
									  'status'=>0
									  ])
							->where('draw_date_time','=',$draw_date_time)
									  ->count();
		if($free_ticket_count > 0)
			return $array = array("status"=>1,"id"=>$free_ticket->id);
		else
			return $array = array("status"=>0,"id"=>0);
	}
	private function update_free_ticket($free_play_id)
	{
		$free_ticket = DB::table('user_free_tickets')->where(['id'=>$free_play_id])->update(['status'=>1]);
		
	}
	public function store(Request $request)
	{
		if(Auth::check())
		{
			// echo "<pre>";
			// print_r($_POST);
			// exit;
			$data_post = $_POST;
			session(['lottery_id'=>$request->lottery_id]);
			$lottery_info = $this->get_lottery(session('lottery_id'));
			$lottery= $this->get_lottery(session('lottery_id'));
			$time_slot = $this->get_time_slot($lottery->draw_timing);
			if($time_slot)
				$ts_name = $time_slot->name;
			else
				$ts_name = "";
			
			session(['lottery_select_val'=>$request->lottery_select_val]);
			session(['lottery_select_val_power_ball'=>$request->lottery_select_val_power_ball]);
			if(isset($_POST['auto-num-'.$request->lottery_id]))
			session(['lottery_type'=> preg_replace('/\d+/u', '', $_POST['auto-num-'.$request->lottery_id.''])]);
			else
			session(['lottery_type'=> "auto"]);	
			session(['ts_name'=>$ts_name]);
			session(['ticket_no'=>$request->ticket_no]);
			session(['total_price'=>$request->ticket_no * $lottery->ticket_price]);
			
			session(['total_price'=>$request->ticket_no * $lottery->ticket_price]);
			
			if(session('ticket_no') > 1)
			{
				for($i=1;$i <= session('ticket_no');$i++)
				{
					$random_code = $this->generateCode(6);
					$powerball    = $this->generateCodePowerball(1);
					
					 $random_array[] = $random_code;
					 $powerball_array[] = array($powerball);
				}
			}
			else
			{
				$random_array[] = explode(",",session('lottery_select_val'));
				$powerball_array[] = explode(",",session('lottery_select_val_power_ball'));
			}
			$draw_array = $this->get_lottery_next_draw_date_and_time($lottery->id);
		    $draw_day  = $draw_array["day"];
			$draw_date_time = date("d M Y",strtotime($draw_day))." ".$lottery->draw_timing;
			
			$draw_datet = date("Y-m-d h:i:s",strtotime("$draw_day $lottery->draw_timing"));
			$draw_date = date("Y-m-d",strtotime($draw_day));
			$free_play_array = $this->get_user_free_ticket_val(session('lottery_id'),$draw_date,$draw_datet);
			$free_play = $free_play_array["status"];
			$free_play_id = $free_play_array["id"];
			
			session(['random_array'=>$random_array]);
			session(['powerball_array'=>$powerball_array]);
			session(['lottery_name'=>$lottery->name]);
			session(['lottery_price'=>$lottery->ticket_price]);
			session(['draw_date_time'=>$draw_date_time]);
			
				
			
			// echo "<pre>";
			// print_r(session('random_array'));
			// print_r(session('powerball_array'));
			
			// exit;
			
						
			$data['lottery_id'] = $request->lottery_id;
			$data['lottery_name'] = $lottery->name;
			$data['lottery_price'] = $lottery->ticket_price;
			
			
			
			$wallet  = $this->check_uses_wallet();
			$balance = session('total_price') - $wallet;
			session(['balance'=>$balance]);
			
			
					 
			// check user wallet balance
			
				if($request->lottery_summary)
				{
					// exit;
					if($free_play==0)
					{
						if(session('total_price') > $wallet)
						{
							return back()->with('error_message',"Your wallet balance is low.Please deposite amount to purchase lottery ticket");
						}
					}
					
				// Add lottery ticket
				
					$j=0;
					foreach(session('random_array') as $random_no)
					{
						$random_no_val = implode(",",$random_no);
						$powerball_no_val = implode(",",$powerball_array[$j]);
						$add_lottery_id = $this->add_lottery_ticket($lottery,$random_no_val,$powerball_no_val,1,session('lottery_type'),session('ticket_no'),session('total_price'),$free_play_id);
				        session(['add_lottery_id'=>$add_lottery_id]);
						// Add transaction
						$order_id  = "ORDER00".(rand(1000000,9999999999))."U".Auth::user()->id;
						if($free_play==0)
						$this->transaction_save_debit($order_id,$lottery->id,$lottery->ticket_price,$add_lottery_id);
						$j++;
					}
					
				
				  Session::forget('lottery_id');
				  Session::forget('lottery_back_url');
				  
				$user = $this->get_user(Auth::user()->id);
			    $subject = "Lottery Purchase";
			    $message = $this->get_order_mail_body(session('lottery_id'));
		
		
		        $this->send_order_mail($user->email,$message,$user->first_name,$subject);
				if($free_play_id > 0)
				{
					$this->update_free_ticket($free_play_id);
				}
			    return redirect('my-history')->with('message','Thanks for purchasing lottery. Please check your mail for more information.');
				}
				else
				{
					// exit;
					return view('paypal.lottery-summary',compact('data_post','wallet','lottery'));
				}
					
			
				// Add lottery ticket
			//	$add_lottery_id = $this->add_lottery_ticket($lottery,$request->lottery_select_val,$request->lottery_select_val_power_ball,0,$data['lottery_type']);
				
				//session(['add_lottery_id'=>$add_lottery_id]);
				//$balance = $lottery->cat1_val - $this->check_uses_wallet();
			  //  return view('paypal.create',compact('lottery','balance','wallet','ts_name'));
			   // return  redirect('my-banking')->with("error_message",'Your Wallet Balance Is Low. So Please Select Atleast One Payment Method To Draw Lottery Ticket');
			
		}
		else
		{
			return redirect('signin');
		}
	}
	private function get_order_mail_body($lottery_id)
	{
		$lottery_info = $this->get_lottery($lottery_id);
		$url=url("my-history");
		 $message = '';
		 $message  .= 'Thanks for purchasing lottery on Bewin.one <br><br>
			Below are Lottery Details.
			<br><br> 
                        
                            <h2>Lottery Details</h2>
							<table width="100%">
							<tr>
							  <td><b>Sr No.</b></td>
							  <td><b>Date</b></td>
							  <td><b>Lottery Name</b></td>
							  <td><b>Selected No.</b></td>
							  <td><b>Price</b></td>
							  <td style="width: 195px;"><b>Draw Date & Time</b></td>                           
						    </tr>';
							$i=1;
							$j=0;
							$powerball_array = session('powerball_array');
							
								foreach(session('random_array') as $random_no)
								{
								  $message .='<tr>
									<td>'.$i.'</td>
									<td>'.date("d-m-Y").'</td>
									<td>'.session('lottery_name').'</td>
									<td>
									<span style="color:green;"  >'.implode(",",$random_no).'</span>,';
									
									$powerball_no_val = implode(",",$powerball_array[$j]);
									$message .='<span style="color:blue;">'.$powerball_no_val.'</span>
									</td>
									<td>$'.session('lottery_price').'</td>
									<td>'.session('draw_date_time').'</td>
									
								  </tr>';
								  $i++; 
								  $j++; 
								}
							
							
					 $message .='
							</table><br><br>
							For more information, please visit your “My History” page.
							<br><br>
							<a href="'.$url.'" class="btn btn-success" style="color:#fff;background-color:#dd4b39;border-color:#d73925;display:inline-block;margin-bottom:0;font-weight:400;text-align:center;white-space:nowrap;vertical-align:middle;background-image:none;border:1px solid transparent;padding:6px 12px;font-size:14px;line-height:1.42857143;border-radius:4px;overflow:visible;text-transform:none">My History</a>
                            ';
					  return $message;
	}
	public function view(Request $request)
	{
		return view('paypal.view');
	}
	public function get_lottery($id)
	{
		return $lottery = Lottery::select('lotteries.*',DB::raw("time_slots.name as draw_timing"),DB::raw("(select ts.name  from time_slots as ts where ts.id=lotteries.end_lottery_time) as end_time"))
		->leftjoin("time_slots",function($join){
			$join->on("time_slots.id","=","lotteries.draw_timing");
		})
		->where(['lotteries.is_deleted'=>0,'lotteries.id'=>$id])
		->first();
		
	}
	public function get_time_slot($id)
	{
		return DB::table("time_slots")->where(["id"=>$id])->first();
	}
	public function get_order($order_id)
	{
		return Order::where('order_id',$order_id)->first();
	}
	public function get_user($id)
	{
		return User::where('id',$id)->first();
	}
	 /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */
    public function payment(Request $request)
    {
		//dd($request);exit;
		// echo session('lottery_id');exit;
		$lottery_id = session('lottery_id');
		$add_lottery_id  = session('add_lottery_id');
		$lottery_info = $this->get_lottery($lottery_id);
		
		$balance = $lottery_info->cat1_val - $this->check_uses_wallet();
		if($this->check_uses_wallet() < $lottery_info->ticket_price)
		{
			$lottery_status = 0;
		}
		else
			$lottery_status = 1;
        $data = [];
        $data['items'] = [
            [
                'name' => $lottery_info->name,
                'price' => $balance,
                'desc'  => 'Play Lottery game',
                'qty' => 1
            ]
        ];
		$order_id = "ORDER00".(rand(1000000,9999999999))."U".Auth::user()->id;
		$user_id = Auth::user()->id;
		$price = $balance;
		$this->order_save($order_id,$price,$user_id,$lottery_status,$lottery_info->id);
		
        $invoice_id = $data['invoice_id'] = $order_id;
        $data['invoice_description'] = "Order #$invoice_id Invoice";
        $data['return_url'] = url('payment/success?order_id='.$order_id);
        $data['cancel_url'] = url('payment/cancel?order_id='.$order_id);
        $data['total'] = $price;
  
        $provider = new ExpressCheckout;
  
        $response = $provider->setExpressCheckout($data);
  
        $response = $provider->setExpressCheckout($data, true);
  
        return redirect($response['paypal_link']);
    }
   public function order_save($order_id,$price,$user_id,$lottery_status,$lottery_id)
	{
		
		
		$order = new Order();
		$order->order_id = $order_id;
		$order->price = $price;
		$order->transaction_id = '';
		$order->status = 'pending';
		$order->user_id = $user_id;
		$order->order_date = date('Y-m-d');
		$order->lottery_status = $lottery_status;
		$order->lottery_id = $lottery_id;
		$order->add_lottery_id = session('add_lottery_id');
		$order->save();
		
	}  
	public function transaction_save($order_id,$lottery_id)
	{
		$order = $this->get_order($order_id);
		if($order)
		{
		$transaction = New Transaction;
		$transaction->user_id = Auth::user()->id; 
		$transaction->party_name = Auth::user()->first_name." ".Auth::user()->last_name; 
		$transaction->sales_ledger = Auth::user()->first_name." ".Auth::user()->last_name; 
		$transaction->description = 'Amount Received'; 
		$transaction->comment = 'Amount Received'; 
		$transaction->lottery_id = $lottery_id; 
		$transaction->form_name ="lottery_add"; 
		$transaction->order_id = $order_id; 
		$transaction->invoice_number = $order_id; 
		$transaction->transaction_date = date('Y-m-d'); 
		$transaction->today_date = date('Y-m-d'); 
		$transaction->cr = $order->price ;
		$transaction->rel_id = $order->id;
		$transaction->p_type = "paid";
		$transaction->save();
		}
	}
	public function transaction_save_debit($order_id,$lottery_id,$price,$rel_id)
	{
		$lottery_info = $this->get_lottery($lottery_id);
		
		$transaction = New Transaction;
		$transaction->user_id = Auth::user()->id; 
		$transaction->party_name = Auth::user()->first_name." ".Auth::user()->last_name; 
		$transaction->sales_ledger = Auth::user()->first_name." ".Auth::user()->last_name; 
		$transaction->description = 'Lottery Purchase Ticket'; 
		$transaction->comment = 'Lottery Purchase Ticket'; 
		$transaction->lottery_id = $lottery_id; 
		$transaction->add_lottery_id = session('add_lottery_id');
		$transaction->form_name ="lottery_add"; 
		$transaction->order_id = $order_id; 
		$transaction->invoice_number = $order_id; 
		$transaction->transaction_date = date('Y-m-d'); 
		$transaction->today_date = date('Y-m-d'); 
		$transaction->dr = $lottery_info->ticket_price ;
		$transaction->rel_id = $rel_id;
		$transaction->p_type = "paid";
		$transaction->save();
		
	}
    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */
    public function cancel(Request $request)
    {
		$order_id = $request->order_id;
			
			$order = Order::where(['order_id'=>$request->order_id])->first();
			$order->status = 'failed';
			$order->type = 'paypal';
			$order->currency = "USD";
			$order->payment_mode = "paypal";
			$order->transaction_id = "";
			$order->token = $request->token;
			$order->save();
			 
			// Add lottery ticket
			    $this->update_lottery_ticket($order->add_lottery_id,$order->id,0);
				
				
		return view('paypal.cancel');
		
        // dd('Your payment is canceled. You can create cancel page here.');
    }
	public function success_show()
    {
		return view('paypal.success');
        // dd('Your payment is canceled. You can create cancel page here.');
    }
  
    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */
    public function success(Request $request)
    {
		// echo "check";exit;
		  $provider = new ExpressCheckout;
  
        $response = $provider->getExpressCheckoutDetails($request->token);
  
        if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
			$order_id = $request->order_id;
			
			$order = Order::where(['order_id'=>$request->order_id])->first();
			$order->status = 'complete';
			$order->type = 'paypal';
			$order->currency = "USD";
			$order->payment_mode = "paypal";
			$order->transaction_id = $request->PayerID;
			$order->token = $request->token;
			$order->save();
			
			$this->transaction_save($order_id,$order->lottery_id);
			
			if($order->lottery_status == 0 )
			{
				
				// Add lottery ticket
			    $this->update_lottery_ticket($order->add_lottery_id,$order->id,1);
				// Add transaction
				$this->transaction_save_debit($order->order_id,$order->lottery_id,$order->price,$order->id);
			}
			$user = $this->get_user($order->user_id);
			$subject = "Lottery Purchase";
			$url=url("code");
			$message = $this->get_order_mail_body($order->lottery_id);
		
		
		$this->send_order_mail($user->email,$message,$user->first_name,$subject);
			
			
            // dd('Your payment was successfully. You can create success page here.');
			return view('paypal.success');
        }
  
        dd('Something is wrong.');
    }
	
	private function update_lottery_ticket($lottery_id,$order_id,$status)
	{
		$add_lottery_ticket = AddLotteryTicket::find($lottery_id);
		$add_lottery_ticket->status = $status;
		$add_lottery_ticket->save();
		
		$order = Order::where(['id'=>$order_id])->first();
		$order->lottery_status = $status;
		$order->save();
	}
	public function send_order_mail($email,$msg,$name,$subject)
	{
		Mail::to($email)
		->send(new Usermail($msg,$name,$subject));
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
