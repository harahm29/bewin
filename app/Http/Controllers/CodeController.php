<?php

namespace App\Http\Controllers;

use App\Code;
use App\User;
use Illuminate\Http\Request;
use App\Voucher;
use App\Commission;
use App\Lottery;
use App\Order;
use App\Transaction;
use App\AddLotteryTicket;
use Auth;
use Validator;
use DB;
use Session;
use Srmklive\PayPal\Services\ExpressCheckout;
use Illuminate\Support\Facades\Mail;
use App\Mail\Usermail;
use App\Withdraw;
use App\UserPaypal;

class CodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function code_purchase(Request $request)
    {
        //
		$vouchers = Voucher::where(['is_deleted'=>0])->orderBy('id','asc')->get();
		$commissions = Commission::where(['is_deleted'=>0])->orderBy('id','asc')->get();
		$commissions_count = Commission::where(['is_deleted'=>0])->count();
		$comm = json_encode($commissions);
		// echo $comm[1]['min_val'];
		// echo "<pre>";
		// print_r($comm);
		// exit;
		return view('code.code-purchase',compact('vouchers','commissions','comm','commissions_count'));
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
	public function code_purchase_post(Request $request)
    {
        //
		// echo "<pre>";
		// print_r($_POST);
		// print_r (session("voucher_no"));
		// exit;
		 // $validator = Validator::make($request->all(),[
            // 'grand_total' => 'required',
            
        // ]);
		
        // if($validator->fails())
        // {
            // return back()
            // ->withInput()
            // ->withErrors($validator);
        // }
		$wallet = $this->check_uses_wallet();
		if(Auth::user()->type=='user')
		{
			
			
			$user_id = Auth::user()->id;
			$user = $this->get_user($user_id);
			$admin = $this->get_user(1);
			$order_id = "ORDER00".(rand(1000000,9999999999))."U".Auth::user()->id;
			
			if($request->type=="code")
			{
				$validator = Validator::make($request->all(),[
				'code' => 'required',
				]);
				if($validator->fails())
				{
					return back()
					->withInput()
					->withErrors($validator);
				}
				
				$data = $this->check_code_val($request->code);
				$status = $data["status"];
				$value = $data["value"];
				$code_id = $data["code_id"];
				if($value < 1 || $value==0)
				{
					return back()->with("error_message","Please Add Valid Code")->withInput();
				}
				if($status==0)
				{
					return back()->withInput()->withErrors($validator)->with("error_message","Invalid Code Please Try Again");
				}
				else if($status==2)
				{
					return back()->withInput()->withErrors($validator)->with("error_message","The Entered Code is Used.Please Try Again");
				}
				else if($status==3)
				{
					return back()->withInput()->withErrors($validator)->with("error_message","The Entered Code is Expired.Please Try Again");
				}
				else
				{
					
					
					
					session(['code'=>$request->code]);
					session(['code_val'=>$value]);
					session(['code_id'=>$code_id]);
					session(['code_type'=>"agent_code"]);
					$balance = $value ;
					$price = $value;
					
					
					$subject = "Order Confirmation";
					$url=url("code");
					
					$this->update_code_status(session("code"));
					
					$this->order_save($order_id,$price,$user_id,1);
					$this->transaction_save($order_id);
					
					$message = 'Thank you for order with us. <br><br>
					You successfully redeem the code. The value of code is added to your wallet balance. Code Details is <br><br>
					<div class="row">
						<div class="col-md-10">
							<h2>Code Details</h2>
								<strong>Code :</strong> '.session("code").' <br>
								<strong>Price:</strong> <span class="text-navy">$'.session("code_val").'</span><br>      
								</div>
							  </div>
					<br><br>
					';
				
					
					$this->send_order_mail($user->email,$message,$user->first_name,$subject);
					$this->send_order_mail($admin->other_email,$message,$admin->first_name,$subject);
					return back()->with("message","You successfully redeem code and your wallet is updated");
				}
			}
			else
			{
				$value = $request->amount;
				$validator = Validator::make($request->all(),[
				'amount' => 'required',
				]);
				
				if($validator->fails())
				{
					return back()
					->withInput()
					->withErrors($validator);
				}
				if($value < 1 || $value==0)
				{
					return back()->with("error_message","Please Add Valid Amount")->withInput();
				}
				$balance = $value;
				$price = $value;
				session(['code_val'=>$price]);
				session(['code_type'=>"paypal"]);
				return view('code.make-payment',compact('balance','price','wallet'));
			}
		}
		else
		{
			 $balance = $request->grand_total - $this->check_uses_wallet();
			 $price = $request->grand_total;
			 session(['voucher_no'=>$request->voucher_no]);
			 session(['total_no'=>$request->total_no]);
			 session(['total'=>$request->total]);
			 session(['commission'=>$request->commission]);
			 session(['discount'=>$request->commission]);
			 session(['discount_per'=>$request->commission_val]);
			 session(['grand_total'=>$request->grand_total]);
			 session(['commission_id'=>$request->commission_id]);
			 session(['payment_method'=>$request->payment_method]);
		}
		// echo "<pre>";
		// print_r($_POST);
		// exit;
		// check user wallet balance
		
			if($this->check_uses_wallet() >= $price)
			{
				/* // Add lottery ticket
				$add_lottery_id = $this->add_lottery_ticket($lottery_info,$request->lottery_select_val,$request->lottery_select_val_power_ball,1,$data['lottery_type']);
				session(['add_lottery_id'=>$add_lottery_id]);
				// Add transaction
				$order_id  = 0;
				$this->transaction_save_debit($order_id,$lottery_info->id,$lottery_info->cat1_val,$add_lottery_id); */
			  //return back()->with('message','Your Lottery Added Successfully');
			}
			else
			{
				if($request->payment_method=='paypal')
			    return view('code.make-payment',compact('balance','price','wallet'));
				else
			    return view('code.make-payment-stripe',compact('balance','price','wallet'));
			}
    }  
	public function index(Request $request)
    {
        //
		if($request->status)
		{
			$status = $request->status;
			$codes = Code::where(['user_id'=>Auth::user()->id,'is_deleted'=>0,'status'=>$request->status])->orderBy('id','desc')->paginate(10);
		}
		else
		{
			$status = "";
			$codes = Code::where(['user_id'=>Auth::user()->id,'is_deleted'=>0])->orderBy('id','desc')->paginate(10);
		}
		return view("code.index",compact('codes','status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Code  $code
     * @return \Illuminate\Http\Response
     */
    public function show(Code $code)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Code  $code
     * @return \Illuminate\Http\Response
     */
    public function edit(Code $code)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Code  $code
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Code $code)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Code  $code
     * @return \Illuminate\Http\Response
     */
    public function destroy(Code $code)
    {
        //
		$code->is_deleted = 1;
		if($code->save())
		{
			return back()->with("message","Code Deleted Successfully");
		}
    }
	
	public function code_payment(Request $request)
    {
		//dd($request);exit;
		// echo "<pre>";
		// print_r($_POST);
		// exit;
		
		if(Auth::user()->type=='user')
		{
			$price = session('code_val');
			$balance = $price;
		}
		else
		{
			$price = session('grand_total');
			$balance = $price - $this->check_uses_wallet();
		}
		if($this->check_uses_wallet() < $price)
		{
			$lottery_status = 0;
		}
		else
			$lottery_status = 1;
        $data = [];
        $data['items'] = [
            [
                'name' => Auth::user()->first_name,
                'price' => $balance,
                'desc'  => 'Play Lottery game',
                'qty' => 1
            ]
        ];
		$order_id = "ORDER00".(rand(1000000,9999999999))."U".Auth::user()->id;
		$user_id = Auth::user()->id;
		$price = $balance;
		$this->order_save($order_id,$price,$user_id,$lottery_status);
		
        $invoice_id = $data['invoice_id'] = $order_id;
        $data['invoice_description'] = "Order #$invoice_id Invoice";
        $data['return_url'] = url('code-success?order_id='.$order_id);
        $data['cancel_url'] = url('code-cancel?order_id='.$order_id);
        $data['total'] = $price;
  
        $provider = new ExpressCheckout;
  
        $response = $provider->setExpressCheckout($data);
  
        $response = $provider->setExpressCheckout($data, true);
  
        return redirect($response['paypal_link']);
    }
	public function get_order($order_id)
	{
		return Order::where('order_id',$order_id)->first();
	}
	public function get_user($id)
	{
		return User::where('id',$id)->first();
	}
   public function order_save($order_id,$price,$user_id,$lottery_status)
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
		
		
		if(Auth::user()->type=='user')
		{
			$order->lottery_id =  session("code_id") ?? 0; 
			if(session("code_type")=='agent_code')
			$order->type =  "code_redeem";
			else
			$order->type =  "paypal";
			$order->currency = "USD";
			$order->payment_mode = "cash";
			$order->transaction_id = "";
			$order->token = rand(10000,19080);
		}
		else
		{
		$order->type = "code_purchase";
		}
		$order->save();
		
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
		
		$transaction->comment = 'Amount Received'; 
		$transaction->lottery_id = 0;
		$transaction->invoice_number = $order_id;
		if(Auth::user()->type=="agent")
		{
		$transaction->form_name ="code_purchase";
		$transaction->description = 'Code Purchase'; 
		$transaction->discount = session('discount'); 
		$transaction->discount_per = session('discount_per'); 
		$transaction->total = session('total'); 
		$transaction->grand_total = session('grand_total'); 
		}
		else
		{
		$transaction->description = 'Deposite Amount Via Paypal'; 
		if(session("code_type")=='agent_code')
		$transaction->form_name ="code_redeem";	
		else
		$transaction->form_name ="paypal";	
		$transaction->invoice_number = session("code") ?? 0;
		$transaction->lottery_id = session("code_id") ?? 0;
		}
		$transaction->order_id = $order_id; 
		$transaction->transaction_date = date('Y-m-d'); 
		$transaction->today_date = date('Y-m-d'); 
		$transaction->cr = $order->price ;
		$transaction->rel_id = $order->id;
		$transaction->p_type = "paid";
		$transaction->save();
		}
	}
	public function transaction_save_debit($order_id,$price,$rel_id)
	{
		
		
		$transaction = New Transaction;
		$transaction->user_id = Auth::user()->id; 
		$transaction->party_name = Auth::user()->first_name." ".Auth::user()->last_name; 
		$transaction->sales_ledger = Auth::user()->first_name." ".Auth::user()->last_name; 
		
		$transaction->comment = 'Amount Debit'; 
		$transaction->lottery_id = 0; 
		$transaction->add_lottery_id = session('add_lottery_id') ?? 0;
		if(Auth::user()->type=="agent")
		{
		$transaction->form_name ="code_purchase";
		$transaction->description = 'Amount Debit Code Purchase'; 
		}
		else
		{
			if(session("code_type")=='agent_code')
			$transaction->form_name ="code_redeem";	
			else
			$transaction->form_name ="paypal";	
		$transaction->description = 'Amount Debit'; 
		}
		$transaction->order_id = $order_id; 
		$transaction->invoice_number = $order_id; 
		$transaction->transaction_date = date('Y-m-d'); 
		$transaction->today_date = date('Y-m-d'); 
		$transaction->dr = $price ;
		$transaction->rel_id = $rel_id;
		$transaction->p_type = "paid";
		$transaction->save();
		
	}
    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */
    public function code_cancel(Request $request)
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
    public function code_success(Request $request)
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
			$order->lottery_status = 1;
			$order->save();
			
			$this->transaction_save($order_id);
			
			// if($order->lottery_status == 0 )
			// {
				
				// Add lottery ticket
			   
			// }
			$user = $this->get_user($order->user_id);
			
			$url=url("agent-history");
			if(Auth::user()->type=='agent')
			{
				$subject = "Buy Code";
				 $this->add_code($order->add_lottery_id,$order->id,1);
				// Add transaction
				$this->transaction_save_debit($order->order_id,$order->price,$order->id);
				
				 Session::forget('voucher_no');
				 Session::forget('total_no');
				 Session::forget('total');
				 Session::forget('commission');
				 Session::forget('grand_total');
				 Session::forget('commission_id');
			$message = 'Thank you for making purchase in bewin.one. <br><br>

			Your code successfully created. Please visit your dashboard. <br><br>
			<a href="'.$url.'" class="btn btn-success" style="color:#fff;background-color:#dd4b39;border-color:#d73925;display:inline-block;margin-bottom:0;font-weight:400;text-align:center;white-space:nowrap;vertical-align:middle;background-image:none;border:1px solid transparent;padding:6px 12px;font-size:14px;line-height:1.42857143;border-radius:4px;overflow:visible;text-transform:none">View Code</a><br><br>
			';
			}
			else
			{
				
			if(session("code_type")=='agent_code')
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
			
            // dd('Your payment was successfully. You can create success page here.');
			
			return view('paypal.success');
        }
  
        dd('Something is wrong.');
    }
	public function update_code_status($code)
	{
		$code_count = Code::where(["code"=>$code,'is_deleted'=>0])->count();
		if($code_count > 0)
		{
			
		$code = Code::where(["code"=>$code,'is_deleted'=>0])->first();
		//echo "session >> ".$code->status;exit;
		$code->status = 2;
		$code->redeem_user_id = Auth::user()->id;
		$code->save();
		
		}
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
	public function user_code_purchase(Request $request)
	{
		return view("code.user-code-purchase");
	}
	public function user_code_purchase_post(Request $request)
	{
		return view("code.user-code-purchase");
	}
	public function check_code_val($code)
	{
		$code_count = Code::where(["code"=>$code,'is_deleted'=>0])->count();
		
		if($code_count > 0)
		{
			$code = Code::where(["code"=>$code,'is_deleted'=>0])->first();
			$data['status'] = $code->status;
			$data['value'] = $code->value;
			$data['code_id'] = $code->id;
		}
		else
		{
			$data['status'] = 0;
			$data['value'] = 0;
			$data['code_id'] = 0;
		}
		return ($data);
	}
	
	public function check_code(Request $request)
	{
		$code_count = Code::where(["code"=>$request->code,'is_deleted'=>0])->count();
		
		if($code_count > 0)
		{
			$code = Code::where(["code"=>$request->code,'is_deleted'=>0])->first();
			$data['status'] = $code->status;
			$data['value'] = $code->value;
		}
		else
		{
			$data['status'] = 0;
			$data['value'] = 0;
		}
		return json_encode($data);
	}
	// Show my banking page
	public function my_banking(Request $request)
	{
		if($request->query())
        {
			if($request->from!="")
			{
			  $from_date = date("Y-m-d",strtotime($request->from)); 
			  $to_date  =  date("Y-m-d",strtotime($request->to));
			}
			else
			{
			  $from_date = date("Y-04-01"); 
			  $to_date  =  date("Y-m-d");
			}
			
			$old_date_data =DB::table('transactions')
			->select(DB::raw('SUM(dr) - SUM(cr) as total_dr_cr'))
			->whereBetween('transaction_date',[$from_date,$to_date])
			// ->groupBy('form_name')
			->orderBy('id', 'DESC')
			->get();
			
		
			$old_date_data =0;	
			if($request->name)
				$user_id = $request->name;
			else
				$user_id = Auth::user()->id;
			
			$transactions = DB::table('users')
			->leftjoin('transactions','users.id','transactions.user_id')
			->whereBetween('transactions.transaction_date', [$from_date,$to_date])
			->where(['transactions.user_id'=>$user_id])
			->orderBy('transactions.id','desc')->paginate(10);
		
		$search='';
		}
		else
		{
			$transactions = Transaction::where(['user_id'=>Auth::user()->id])->orderBy('id','desc')->paginate(10);
			$search='';
			$old_date_data = 0;
		}
		$paypal_ids = UserPaypal::where(['user_id'=>Auth::user()->id,'is_deleted'=>0])->orderBy('id','desc')->get();
		$withdraw_request_sum = Withdraw::where(['user_id'=>Auth::user()->id,'is_deleted'=>0,'status'=>0])->sum('amount');
		$wallet = $this->check_uses_wallet() - $withdraw_request_sum;
		return view("code.my-banking",compact('transactions','search','old_date_data','paypal_ids','wallet'));
	}
	public function withdraw_fund(Request $request)
	{
		// echo "<pre>";
		// print_r($_POST);
		// exit;
			$validator = Validator::make($request->all(),[
				'withdraw_amount' => 'required',
				'paypal_id' => 'required',
				]);
			
			if($validator->fails())
			{
				return back()
					->withInput()
					->withErrors($validator);
			}
			$withdraw_request_sum = Withdraw::where(['user_id'=>Auth::user()->id,'is_deleted'=>0,'status'=>0])->sum('amount');
			$wallet = $this->check_uses_wallet() - $withdraw_request_sum;
			if($request->withdraw_amount > $wallet)
			{
				return back()->with("error_message","Withdraw amount not greater than to your available fund")->withInput();
			}
			else
			{
				$count = $this->check_paypal_withdraw_request();
				
				$withdraw = new Withdraw;
				$withdraw->user_id = Auth::user()->id;
				$withdraw->amount = $request->withdraw_amount;
				$withdraw->type = $request->type;
				$withdraw->paypal_id = $request->paypal_id ?? "";
				$withdraw->today_date = date("Y-m-d");
				$withdraw->status = 0;
				$withdraw->save();
				
				$user = $this->get_user(Auth::user()->id);
			    $subject = "Withdraw Request- Successful";
			    $message = "You have successfully place withdraw request.";
		        $this->send_order_mail($user->email,$message,$user->first_name,$subject);
				
				return back()->with("message","Withdraw request has been submited")->withInput();
			}
	}
	private function check_paypal_withdraw_request()
	{
		return Withdraw::where(['user_id'=>Auth::user()->id,'is_deleted'=>0,'status'=>0,'type'=>'paypal'])->count();
	}
	public function wiretransfer_fund(Request $request)
	{
		// echo "<pre>";
		// print_r($_POST);
		// exit;
			$validator = Validator::make($request->all(),[
				'withdraw_amount_wiretransfer' => 'required',
				'account_holder_name' => 'required',
				'account_no' => 'required',
				'phone_no' => 'required',
				'bank_name' => 'required',
				'branch_name' => 'required',
				'swift_code' => 'required',
				'branch_address' => 'required',
				]);
			
			if($validator->fails())
			{
				return back()
					->withInput()
					->withErrors($validator);
			}
			$withdraw_request_sum = Withdraw::where(['user_id'=>Auth::user()->id,'is_deleted'=>0,'status'=>0])->sum('amount');
			$wallet = $this->check_uses_wallet() - $withdraw_request_sum;
			if($request->withdraw_amount_wiretransfer > $wallet)
			{
				return back()->with("error_message","Withdraw amount not greater than to your available fund")->withInput();
			}
			else
			{
				$count = $this->check_paypal_withdraw_request();
				
				$withdraw = new Withdraw;
				$withdraw->user_id = Auth::user()->id;
				$withdraw->amount = $request->withdraw_amount_wiretransfer;
				$withdraw->type = $request->type;
				$withdraw->paypal_id = $request->paypal_id ?? "";
				$withdraw->account_holder_name = $request->account_holder_name  ?? "";
				$withdraw->account_no = $request->account_no  ?? "";
				$withdraw->phone_no = $request->phone_no  ?? "";
				$withdraw->bank_name = $request->bank_name  ?? "";
				$withdraw->branch_name = $request->branch_name  ?? "";
				$withdraw->swift_code = $request->swift_code  ?? "";
				$withdraw->branch_address = $request->branch_address  ?? "";
				$withdraw->today_date = date("Y-m-d");
				$withdraw->status = 0;
				$withdraw->save();
				
				$user = $this->get_user(Auth::user()->id);
			    $subject = "Withdraw Request- Successful";
			    $message = "You have successfully place withdraw request.";
		        $this->send_order_mail($user->email,$message,$user->first_name,$subject);
				
				return back()->with("message","Withdraw request has been submited")->withInput();
			}
	}
	public function agent_history(Request $request)
	{
		$user =  $this->get_user(Auth::user()->id);
		$codes = DB::table("codes")->select("*",DB::raw("sum(`value`) as total_value"),DB::raw("count(`code`) as total_code"))
					->where(['is_deleted'=>0,'user_id'=>Auth::user()->id])
					->orderBy('id','desc')
					->groupBy('today_date')->paginate(10);
		
		
		return view ('code.agent-history',compact('codes','user'));
	}
	public function agent_code_listing(Request $request,$date)
	{
		$user =  $this->get_user(Auth::user()->id);
		$vouchers = Voucher::where(['is_deleted'=>0])->get();
		if($request->query())
		{
			$status_code = $request->status ?? "";
			$amount = $request->amount ?? "";
			$plan = $request->plan ?? "";
			
			
			
			$codes = DB::table("codes")->select("codes.*",DB::raw("vs.name as voucher_name"))
						->leftjoin("vouchers as vs",function($join){
							$join->on("vs.id","=","codes.voucher_id");
						})
						->where(['codes.is_deleted'=>0,'codes.user_id'=>Auth::user()->id,'codes.today_date'=>$date]);	
						if($amount)
						{
					$codes =	$codes->where("codes.value",$amount);
						}
						if($plan)
						{
					$codes =	$codes->where("codes.voucher_id",$plan);
						}
						if($status_code)
						{
					$codes =	$codes->where("codes.status",$status_code);
						}
					$codes =	$codes->orderBy('id','desc')->paginate(10);
						
						
		}
		else
		{
			$status_code = "";
			$amount = "";
			$plan = "";
			
			$codes = DB::table("codes")->select("codes.*",DB::raw("vs.name as voucher_name"))
						->leftjoin("vouchers as vs",function($join){
							$join->on("vs.id","=","codes.voucher_id");
						})
						->where(['codes.is_deleted'=>0,'codes.user_id'=>Auth::user()->id,'codes.today_date'=>$date])
						->orderBy('id','desc')->paginate(10);
		}
		// echo "<pre>";
		// print_r($codes);
		// exit;
		return view ('code.agent-code-listing',compact('codes','user','vouchers','status_code','amount','plan'));
	}
////////////////////////////////////////////////////
}
