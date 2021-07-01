<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Code;
use App\Voucher;
use App\Commission;
use App\Lottery;
use App\Order;
use App\Transaction;
use App\AddLotteryTicket;
use Session;
use Auth;
use Validator;
use DB;
use Stripe;
use Illuminate\Support\Facades\Mail;
use App\Mail\Usermail;

class StripePaymentController extends Controller
{
    //
	/**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
	 public function index()
	 {
		 return view('stripe.index');
	 } 
	 public function stripe(Request $request)
	 {
		 $validator = Validator::make($request->all(),[
				'amount' => 'required|min:1',
				'name' => 'required',
				'card_number' => 'required',
				'cvv' => 'required',
				'exp_month' => 'required',
				'exp_year' => 'required',
				]);
			if($validator->fails())
			{
				return back()
					->withInput()
					->withErrors($validator);
			}
			if($request->amount==0 || $request->amount < 1)
			{
				return back()->with("error_message",'Please Enter valid amount')->withErrors();
			}
		 $order_id = "ORDER000".(rand(1000000,9999999999))."U".Auth::user()->id;
		 
		 $user_id = Auth::user()->id;
		 $price = $request->amount;
		 $o_id = $this->order_save($order_id,$price,$user_id,1,$request->name,$request->card_number,$request->exp_month,$request->exp_year);
		 session(["order_id"=>$o_id]);
		 return view('stripe.stripe');
	 }
	  /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
	 public function stripePost(Request $request)
	 {
		 // echo "<pre>";
		 // print_r($_POST);
		 // exit;
		 $validator = Validator::make($request->all(),[
				'amount' => 'required',
				'name' => 'required',
				'card_number' => 'required',
				'cvv' => 'required',
				'exp_month' => 'required',
				'exp_year' => 'required',
				]);
			if($validator->fails())
			{
				return back()
					->withInput()
					->withErrors($validator);
			}
			if($request->amount==0 || $request->amount < 1)
			{
				return back()->with("error_message",'Please Enter valid amount')->withErrors();
			}
		 $order_id = "ORDER000".(rand(1000000,9999999999))."U".Auth::user()->id;
		 
		 $user_id = Auth::user()->id;
		 $price = $request->amount;
		 $o_id = $this->order_save($order_id,$price,$user_id,1,$request->name,$request->card_number,$request->exp_month,$request->exp_year);
		session(["order_id"=>$o_id]);
		session(["code_val"=>$price]);
		 
		if(session("order_id"))
		{
			  Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
			  $charge = Stripe\Charge::create ([
					"amount" =>  100,
					"currency" => "usd",
					"source" => $request->stripeToken,
					"description" => "Test payment from itsolutionstuff.com." 
			]);
			if($charge['status'] == 'succeeded') 
			{
				 // echo "<pre>";
				 // print_r($charge);
				 // exit;
				
				$order = Order::where(['id'=>session("order_id")])->first();
				$order->status = 'complete';
				$order->type = 'stripe';
				$order->currency = "USD";
				$order->payment_mode = "stripe";
				$order->transaction_id = $charge["balance_transaction"];
				$order->token = $request->stripeToken;
				$order->lottery_status = 1;
				$order->save();
				
				$this->transaction_save($order_id);
				
				$user = $this->get_user($order->user_id);
				
				$url=url("agent-history");
				if(Auth::user()->type=='agent')
				{
					 $this->add_code($order->add_lottery_id,$order->id,1);
					// Add transaction
					$this->transaction_save_debit($order->order_id,$order->price,$order->id);
					
					 Session::forget('voucher_no');
					 Session::forget('total_no');
					 Session::forget('total');
					 Session::forget('commission');
					 Session::forget('grand_total');
					 Session::forget('commission_id');
					 $subject = "Buy Code";
				$message = 'Thank you for making purchase in bewin.one. <br><br>

			    Your code successfully created. Please visit your dashboard. <br><br>
				<a href="'.$url.'" class="btn btn-success" style="color:#fff;background-color:#dd4b39;border-color:#d73925;display:inline-block;margin-bottom:0;font-weight:400;text-align:center;white-space:nowrap;vertical-align:middle;background-image:none;border:1px solid transparent;padding:6px 12px;font-size:14px;line-height:1.42857143;border-radius:4px;overflow:visible;text-transform:none">View Code</a><br><br>
				';
				}
				else
				{
					
				if(session("code_type") && (session("code_type")=='agent_code'))
				{
					$subject = "Code Redeem";
				$this->update_code_status(session("code"));
				$message = 'Thank you for order with us. <br><br>

				You successfully redeem the code. The value of code is added to your wallet balance. Code Details is ... <br><br>
				<div class="row">
					<div class="col-md-10">
						<h2>Code Details</h2>
							<strong>Code :</strong> '.session("code").' <br>
							<strong>Price:</strong> <span class="text-navy">$'.session("code_val").'</span><br>      
							</div>
						  </div>
				<br><br>
				';
				}
				else
				{
					$subject = "Deposit Money- Successful";
					$message = 'Congratulations. <br><br>

					You have deposit money in your wallet successfully.<br><br>
					
					<br><br>
					';
				}
				
				}
			
			
			$this->send_order_mail($user->email,$message,$user->first_name,$subject);
				
				 Session::flash('success', 'Payment successful!');
				 return view('paypal.success');
				 //return back()->with("message","Payment Successfull");
			}
			else
			{
				 return view('paypal.cancel');
			}
		}
		else
		{
			return back()->with("error_message","Something Went Wrong. Please Try Again.");
		}
	 }
	 
	 // Order & Transaction
	 public function order_save($order_id,$price,$user_id,$lottery_status,$name,$card_number,$exp_month,$exp_year)
	{
		
		
		$order = new Order();
		$order->order_id = $order_id;
		$order->price = $price;
		$order->transaction_id = '';
		$order->status = 'pending';
		$order->user_id = $user_id;
		$order->order_date = date('Y-m-d');
		$order->lottery_status = $lottery_status;
		$order->lottery_id = 0;
		$order->add_lottery_id = 0;
		$order->name = $name;
		$order->card_number = $card_number;
		$order->exp_month = $exp_month;
		$order->exp_year = $exp_year;
		
		
		if(Auth::user()->type=='user')
		{
			$order->lottery_id =  session("order_id") ?? 0; 
			$order->type =  "stripe";
		}
		else
		{
		$order->type = "code_purchase";
		}
		$order->save();
		return $order->id;
	}  
	public function transaction_save($order_id)
	{
		
		$order = $this->get_order($order_id);
		if($order)
		{
		$transaction = New Transaction;
		$transaction->user_id = Auth::user()->id; 
		$transaction->party_name = Auth::user()->first_name." ".Auth::user()->last_name; 
		$transaction->sales_ledger = Auth::user()->first_name." ".Auth::user()->last_name; 
		
		 
		$transaction->lottery_id = 0;
		$transaction->invoice_number = $order_id;
		if(Auth::user()->type=="agent")
		{
		$transaction->form_name ="code_purchase";
		$transaction->discount = session('discount'); 
		$transaction->discount_per = session('discount_per'); 
		$transaction->total = session('total'); 
		$transaction->grand_total = session('grand_total');
		$transaction->comment = 'Code Purchase Via Stripe';	
		$transaction->description = 'Code Purchase Via Stripe'; 		
		}
		else
		{
		$transaction->form_name ="stripe";	
		$transaction->invoice_number = session("order_id") ?? 0;
		$transaction->lottery_id = session("order_id") ?? 0;
		$transaction->comment = 'Amount Received Via Stripe';
		$transaction->description = 'Amount Received Via Stripe'; 
		}
		$transaction->order_id = $order_id; 
		$transaction->transaction_date = date('Y-m-d'); 
		$transaction->today_date = date('Y-m-d'); 
		$transaction->cr = $order->price ;
		$transaction->rel_id = $order->id;
		$transaction->p_type = "stripe";
		$transaction->save();
		}
	}
	public function transaction_save_debit($order_id,$price,$rel_id)
	{
		
		
		$transaction = New Transaction;
		$transaction->user_id = Auth::user()->id; 
		$transaction->party_name = Auth::user()->first_name." ".Auth::user()->last_name; 
		$transaction->sales_ledger = Auth::user()->first_name." ".Auth::user()->last_name; 
		$transaction->description = 'Amount Debit'; 
		$transaction->comment = 'Amount Debit Via Stripe'; 
		$transaction->lottery_id = 0; 
		$transaction->add_lottery_id = session('add_lottery_id') ?? 0;
		if(Auth::user()->type=="agent")
		$transaction->form_name ="code_purchase";
		else
		{
			if(session("code_type")=='agent_code')
			$transaction->form_name ="code_redeem";	
			else
			$transaction->form_name ="paypal";	
		}
		$transaction->order_id = $order_id; 
		$transaction->invoice_number = $order_id; 
		$transaction->transaction_date = date('Y-m-d'); 
		$transaction->today_date = date('Y-m-d'); 
		$transaction->dr = $price ;
		$transaction->rel_id = $rel_id;
		$transaction->p_type = "stripe";
		$transaction->save();
		
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
	public function get_order($order_id)
	{
		return Order::where('order_id',$order_id)->first();
	}
	public function get_user($id)
	{
		return User::where('id',$id)->first();
	}
	public function send_order_mail($email,$msg,$name,$subject)
	{
		Mail::to($email)
		->send(new Usermail($msg,$name,$subject));
	}
	private function add_code($lottery_id,$order_id,$status)
	{
		foreach(session("voucher_no") as $key=>$val)
		{
			if($val && $val > 0)
			{
				for($i=1;$i<=$val;$i++)
				{
					$date = date('Y-m-d');
					$voucher = Voucher::find($key);
					$code = new Code;
					$code->user_id = Auth::user()->id;
					$code->voucher_id = $voucher->id;
					$code->commission_id = session("commission_id") ?? 0;
					$code->code = ucwords($this->getToken(10));
					$code->value = $voucher->amount;
					$code->today_date = date('Y-m-d');
					$code->expire_date = date('Y-m-d', strtotime($date.' + '.$voucher->validity.' days'));
					$code->save();
				}
			}
		
		}
		
		
		
	}
	private function getToken($length)
	{
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet.= "0123456789";
    $max = strlen($codeAlphabet);

    for ($i=0; $i < $length; $i++) {
        $token .= $codeAlphabet[random_int(0, $max-1)];
    }

    return $token;
	}
}
