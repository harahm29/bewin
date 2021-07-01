<?php

namespace App\Http\Controllers;
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");
// following files need to be included

// require_once  "paytm/lib/config_paytm.php";
// require_once  "paytm/lib/encdec_paytm.php";


use Illuminate\Support\Facades\Auth;
use App\User;
use App\Order;
use Illuminate\Http\Request;
use App\OrderDetail;
use DB;
use App\OrderCancel;
use App\OrderShipping;
use App\OrderDelivery;
use App\Mail\OrderMail;
class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
      $orders = Order::where('status','complete')->orderBy('id','desc')->get();
      return view('order.index',compact('orders'));
    }
    public function order_fail()
    {
        $order_status="all";
        $orders = Order::where('status','failed')->orderBy('id', 'DESC')->get();
        return view('order.fail',compact('orders','order_status'));
    }
   public function orders($id=null)
	{
		if(Auth::user()->id==1)
		{
			
			$orders = Order::select('orders.*','users.mobile_no','users.name')
			      ->leftJoin('users',function($join){
					$join->on('users.id','=','orders.user_id');
					})
			    ->where(['orders.order_status'=>$id])
			    ->orderBy('orders.id','desc')->get();
					
			if($id==null)
			{
			$order_status = "all";
			$orders = Order::select('orders.*','users.mobile_no','users.name')
			      ->leftJoin('users',function($join){
					$join->on('users.id','=','orders.user_id');
					})
			   // ->where(['orders.status'=>'complete'])
			    ->orderBy('orders.id','desc')->get();
			}
			elseif($id=="failed")
			{
			$order_status = "failed";
			
			$orders = Order::select('orders.*','users.mobile_no','users.name')
			    ->leftJoin('users',function($join){
					$join->on('users.id','=','orders.user_id');
					})
			    ->where(['orders.status'=>'failed'])
				->orderBy('orders.id','desc')->get();
			}
			elseif($id=="complete")
			{
			$order_status = "complete";
			
			$orders = Order::select('orders.*','users.mobile_no','users.name')
			    ->leftJoin('users',function($join){
					$join->on('users.id','=','orders.user_id');
					})
			    ->where(['orders.status'=>'complete'])
				->orderBy('orders.id','desc')->get();
			}
			else
			{
			$order_status = $id;
			
			$orders = Order::select('orders.*','users.mobile_no','users.name')
			      ->leftJoin('users',function($join){
					$join->on('users.id','=','orders.user_id');
					})
			    ->where(['orders.order_status'=>$id,'orders.status'=>'complete'])
				->orderBy('orders.id','desc')->get();
			}
		}
		else
		{
			$executive_id = Auth::user()->id;
			$orders = Order::select('orders.*','users.mobile_no','users.name')
			      ->leftJoin('users',function($join){
					$join->on('users.id','=','orders.user_id');
					})
			    ->where(['orders.order_status'=>$id])
				->whereRaw("orders.user_id in (SELECT id FROM users WHERE executive_id = $executive_id)")
			    ->orderBy('orders.id','desc')->get();
					
			if($id==null)
			{
			$order_status = "all";
			$orders = Order::select('orders.*','users.mobile_no','users.name')
			      ->leftJoin('users',function($join){
					$join->on('users.id','=','orders.user_id');
					})
			    ->where(['orders.status'=>'complete'])
				->whereRaw("orders.user_id in (SELECT id FROM users WHERE executive_id = $executive_id)")
					->orderBy('orders.id','desc')->get();
			}
			elseif($id=="failed")
			{
			$order_status = "failed";
			
			$orders = Order::select('orders.*','users.mobile_no','users.name')
			    ->leftJoin('users',function($join){
					$join->on('users.id','=','orders.user_id');
					})
			    ->where(['orders.status'=>'failed'])
				->whereRaw("orders.user_id in (SELECT id FROM users WHERE executive_id = $executive_id)")
				->orderBy('orders.id','desc')->get();
			}
			elseif($id=="complete")
			{
			$order_status = "complete";
			
			$orders = Order::select('orders.*','users.mobile_no','users.name')
			    ->leftJoin('users',function($join){
					$join->on('users.id','=','orders.user_id');
					})
			    ->where(['orders.status'=>'complete'])
				->whereRaw("orders.user_id in (SELECT id FROM users WHERE executive_id = $executive_id)")
				->orderBy('orders.id','desc')->get();
			}
			else
			{
			$order_status = $id;
			
			$orders = Order::select('orders.*','users.mobile_no','users.name')
			      ->leftJoin('users',function($join){
					$join->on('users.id','=','orders.user_id');
					})
			    ->where(['orders.order_status'=>$id,'orders.status'=>'complete'])
				->whereRaw("orders.user_id in (SELECT id FROM users WHERE executive_id = $executive_id)")
					->orderBy('orders.id','desc')->get();
			}
		}
        return view('order.index',compact('orders','order_status'));
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
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
		
        $order_id = $order->order_id;
        $order_details = OrderDetail::select('order_id','product_id','product_name', 'qty', 'price', 'total_price', 'image')
        ->where('order_id',$order_id)
        ->get();
        
        $main_order = $this->get_order_main_details($order_id);
		
        $user = $this->get_user_email($main_order->user_id);
		// echo "<pre>";
		// print_r($user);exit;
        $address = ($user->email)."<br> ".$user->mobile_no;
        $msg = '<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:16px;">
          <tr>
            <td  height="30" style="border-bottom:1px solid #CCCCCC;">Order Number: <strong>'.$order_id.'</strong> </td>
            <td  align="right" style="border-bottom:1px solid #CCCCCC;">Order Status: <b>'.$main_order->status.'</b> </td>
          </tr>
        </table>
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">
          <tr>
            <td  valign="top" style="border-right:1px solid #CCCCCC; padding-top:12px; padding-bottom:12px;"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
        <td  valign="top"><strong>Bill To: </strong></td>
        <td  valign="top"><strong>'.ucwords($user->name).'</strong>
          </td>
      </tr>
              <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">'.ucwords($address).'
          </td>
      </tr>
      
    </table></td>
    <td valign="top" style="padding-top:12px; padding-bottom:12px;"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
        <td  valign="top"><strong>Ship To: </strong></td>
        <td  valign="top"><strong>'.ucwords($user->name).'</strong>
          </td>
      </tr>
      <tr>
        <td  valign="top">&nbsp;</td>
        <td  valign="top">'.ucwords($address).'</td>
      </tr>
    </table></td>
  </tr>
</table>
        ';


$msg .= '<table width="100%" border="0" align="center" cellpadding="6" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:14px;">
  <tr>
    <td  align="left" style="background-color:#000000; color:#FFFFFF;padding:20xp;font-size:14px;"><strong>Product Description</strong></td>
    <td  align="center" style="background-color:#000000; color:#FFFFFF;padding:20xp;font-size:14px;"><strong>Qty.</strong></td>
    <td  align="right" style="background-color:#000000; color:#FFFFFF;padding:20xp;font-size:14px;"><strong>Unit Price (INR) </strong></td>
    
    <td  align="right" style="background-color:#000000; color:#FFFFFF;padding:20xp;font-size:14px;"><strong>Total Price (INR) </strong></td>
  </tr>';


foreach($order_details as $order)
{   
if($order->type=="product")
    $product_qty="<b>(Qty - ".$order->gift_qty.")</b>";
else
    $product_qty="";
$msg .= '<tr>
    <td align="left" style="border-bottom:1px solid #CCCCCC;">'.$order->product_name.'   '.$product_qty.'</td>
    <td align="center" style="border-bottom:1px solid #CCCCCC;">';
    if($order->qty==0)
    {
        $type=ucfirst($order->type);
        if($type=="Todayoffer")
        $type="Today's Offer";  
    }
    else
        $type=$order->qty;
    $msg .= ''.$type.'</td>
    <td align="right" style="border-bottom:1px solid #CCCCCC;">';
    if($order->type=='')
        $price=$order->price;
    else
        $price='';
    $msg .= ''.$price.'</td>
    <td align="right" style="border-bottom:1px solid #CCCCCC;">'.$order->total_price.'</td>
  </tr>';
    
} 



$msg .= '<tr>
    <td align="left" >&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right">Total</td>
    <td align="right">'.($main_order->price).'</td>
  </tr>
 
  <tr>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right">&nbsp; </td>
    <td align="right">&nbsp;</td>
  </tr>
  
  <tr>
    
    <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
    <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
    <td align="right" bgcolor="#CCCCCC"><strong>Grand Total</strong></td>
    <td align="right" bgcolor="#CCCCCC"><strong>'.$main_order->price.'</strong></td>
  </tr>
</table>';


echo $msg;
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
    public function update_order_status($order_id,$user_id,$order_status,Request $request)
    {
        //echo $order_id;exit;
        $backurl = url()->previous();
        $user = $this->get_user_email($user_id);
        $order = Order::where('order_id',$order_id)->first();
        if($order)
        {
        $order->order_status = $order_status;
        $order->save();
        if($order_status=="received")
        {
            $msg = "Order No - ".$order_id." <br>Your order is successfully received. You order will  be dispatched after 1-2 business days.";
            //send notification and message
            $title="Order Received";
            $this->notification($user->firebase_token, $title,$msg);
            $res = $this->send_mobile_message_url($user->mobile_no,$msg);
        
        }
        else if($order_status=="canceled")
        {
            $msg = "Order No - ".$order_id." <br>Your order is canceled by Admin. The reason of cancel-<br/>".$request->comment;
            
            $ordercancel = new OrderCancel();
            $ordercancel->user_id  = $user_id;
            $ordercancel->order_id = $order_id;
            $ordercancel->comment  = $request->comment;
            $ordercancel->save();
            //send notification and message
            $title="Order Canceled";
            $this->notification($user->firebase_token, $title,$msg);
            $txtmsg = "Order No - ".$order_id." <br>Your order is canceled by Admin. The reason of cancel - ".$request->comment;
            $res = $this->send_mobile_message_url($user->mobile_no,$txtmsg);
        }
        else if ($order_status=="shipped")
        {
            $msg = "Order No - ".$order_id." <br>Your order is successfully shipped . Your shipping details is ....<br/>Tracking Id - ".$request->tracking_id."<br/>Shipping Details - ".$request->shipping_details;
            
            $ordershipping = new OrderShipping();
            $ordershipping->user_id  = $user_id;
            $ordershipping->order_id = $order_id;
            $ordershipping->tracking_id  = $request->tracking_id;
            $ordershipping->shipping_details = $request->shipping_details;
            $ordershipping->save();
            //send notification and message
            
            $description = "Your order is successfully shipped . Your shipping details is ....Tracking Id - ".$request->tracking_id."Shipping Details - ".$request->shipping_details;
            $title="Order Shipped";
            $this->notification($user->firebase_token, $title,$description);
            $txtmsg = "Order No - ".$order_id." <br>Your order is successfully shipped . Your shipping details is ....<br>Tracking Id - ".$request->tracking_id."<br>Shipping Details - ".$request->shipping_details;
            $res = $this->send_mobile_message_url($user->mobile_no,$txtmsg);
        }
        
        //$this->send_user_email($user->email,$msg,$user->name,$title);
        return redirect($backurl)->with('message','Order Status updated successfully');
        }
        else{
        return redirect($backurl)->with('message','Something went wrong');  
        }
    }
    
    public function get_user_email($id)
    {
        $user = User::where('id',$id)->first();
        return $user;
    }
    // public function send_user_email($email,$msg,$name,$subject)
    // {
        // Mail::to($email)->send(new OrderMail($msg,$name,$subject));
    // }
    public function update_order_status1(Request $request)
    {
        //echo $order_id;exit;
        
        $backurl = url()->previous();
        $user = $this->get_user_email($request->user_id);
        $order = Order::where('order_id',$request->order_id)->first();
        if($order)
        {
        $order->order_status = $request->order_status;
        $order->save();
        if ($request->order_status=="delivered")
        {
            $msg = "Order No - ".$order->order_id." <br>Your order is successfully delivered . Your delivery details is ....<br/>Delivery Details - ".$request->additional_details;
            
            if($request->hasFile('delivery_proof') && $request->delivery_proof->isValid())
            {     
                   $extension = $request->delivery_proof->extension();
                   $fileName  = "delivery_proof".time().".$extension";
                   $request->delivery_proof->move(public_path('images'),$fileName);
            }
            else
            {
                   $fileName = "default.jpg";
            }
            $orderdelivery = new OrderDelivery();
            $orderdelivery->user_id  = $request->user_id;
            $orderdelivery->order_id = $request->order_id;
            $orderdelivery->delivery_proof  = $fileName;
            $orderdelivery->additional_details = $request->additional_details;
            $orderdelivery->save();
            
            //send notification and message
            $title="Order Delivered";
            $this->notification($user->firebase_token, $title,$msg);
            $txtmsg = "Order No - ".$order->order_id." <br>Your order is successfully delivered . Your delivery details is ....<br>Delivery Details - ".$request->additional_details;
            $res = $this->send_mobile_message_url($user->mobile_no,$txtmsg);
            
        }
        else if ($request->order_status=="shipped")
        {
            $msg = "Order No - ".$order->order_id." <br>Your order is successfully shipped . Your shipping details is ....<br/>Tracking Id - ".$request->tracking_id."<br/>Shipping Details - ".$request->shipping_details;
            
            if($request->hasFile('delivery_proof') && $request->delivery_proof->isValid())
            {     
                   $extension = $request->delivery_proof->extension();
                   $fileName  = "delivery_proof".time().".$extension";
                   $request->delivery_proof->move(public_path('images'),$fileName);
            }
            else
            {
                   $fileName = "default.jpg";
            }
            $ordershipping = new OrderShipping();
            $ordershipping->user_id  = $request->user_id;
            $ordershipping->order_id = $request->order_id;
            $ordershipping->tracking_id  = $request->tracking_id;
            $ordershipping->shipping_details = $request->shipping_details;
            $ordershipping->delivery_proof  = $fileName;
            $ordershipping->save();
            
            //send notification and message
            $title="Order Shipped";
            $description = "Your order is successfully shipped . Your shipping details is ....Tracking Id - ".$request->tracking_id."Shipping Details - ".$request->shipping_details;
            $this->notification($user->firebase_token, $title,$description);
            $txtmsg = "Order No - ".$order->order_id." <br>Your order is successfully shipped . Your shipping details is ....<br>Tracking Id - ".$request->tracking_id."<br>Shipping Details - ".$request->shipping_details;
            $res = $this->send_mobile_message_url($user->mobile_no,$txtmsg);
        }
        
        //$this->send_user_email($user->email,$msg,$user->name,$title);
        
        return redirect($backurl)->with('message','Order Status updated successfully');
        }
        else{
        return redirect($backurl)->with('message','Something went wrong');  
        }
    }
    public function order_details_admin(Request $request)
    {
        
    }
    public function get_order_main_details($order_id)
    {
        $order = Order::select('*')->where('order_id',$order_id)->first();
        return $order;
    }
    public function show_order_invoice($order_id)
    {
        $order_details = DB::table('order_details')->select('order_id','product_id','product_name', 'qty', 'price', 'total_price', 'payment_mode', 'image')
        ->where('order_id',$order_id)
        ->get();
        
        $main_order = $this->get_order_main_details($order_id);
        $user = $this->get_user_email($main_order->user_id);
        return view('order.ordermail-app',compact('order_details','main_order','user','order_id'));
    }
	
	public function paytm_payment_checksum(Request $request)
	{
		if($this->check_user_token($request->CUST_ID, $request->header('user-token')) == false){
	        $data['user_status'] 					= '0';
	        $data['user_status_message']			= "Invalid Token Number";
	        return $this->sendError('Invalid Token Number.',404);
			}
			
		$data = $this->paytm_credential();
		
		$checkSum = "";
	// below code snippet is mandatory, so that no one can use your checksumgeneration url for other purpose .
	$findme   = 'REFUND';
	$findmepipe = '|';
	$paramList = array();
	$paramList["MID"] = $data['MID'];
	$paramList["ORDER_ID"] = $request->ORDER_ID;
	$paramList["CUST_ID"] = $request->CUST_ID;
	$paramList["INDUSTRY_TYPE_ID"] = $data['INDUSTRY_TYPE_ID'];
	$paramList["CHANNEL_ID"] = $data['CHANNEL_ID'];
	$paramList["TXN_AMOUNT"] = $request->TXN_AMOUNT;
	$paramList["WEBSITE"] = $data['WEBSITE'];
	$paramList["CALLBACK_URL"] = $request->CALLBACK_URL;
//	$PAYTM_MERCHANT_KEY = $request->PAYTM_MERCHANT_KEY;
	foreach($_POST as $key=>$value)
	{  
	  $pos = strpos($value, $findme);
	  $pospipe = strpos($value, $findmepipe);
	  if ($pos === false || $pospipe === false) 
		{
			$paramList[$key] = $value;
		}
	}
	 $this->order_save($request->ORDER_ID,$request->TXN_AMOUNT,$request->CUST_ID); 
	//Here checksum string will return by getChecksumFromArray() function.
	$checkSum = getChecksumFromArray($paramList,PAYTM_MERCHANT_KEY);
	//print_r($_POST);
	 return json_encode(array("CHECKSUMHASH" => $checkSum,"ORDER_ID" => $_POST["ORDER_ID"], "payt_STATUS" => "1","paramList"=>$paramList));
	  //Sample response return to SDK
	 
	//  {"CHECKSUMHASH":"GhAJV057opOCD3KJuVWesQ9pUxMtyUGLPAiIRtkEQXBeSws2hYvxaj7jRn33rTYGRLx2TosFkgReyCslu4OUj\/A85AvNC6E4wUP+CZnrBGM=","ORDER_ID":"asgasfgasfsdfhl7","payt_STATUS":"1"} 
	}
	public function order_save($order_id,$price,$user_id)
	{
		$user = $this->get_user_email($user_id);
		$order = new Order();
		$order->order_id = $order_id;
		$order->price = $price;
		$order->transaction_id = '';
		$order->status = 'pending';
		$order->user_id = $user_id;
		$order->order_date = date('Y-m-d');
		$order->save();
		
	}
	public function paytm_credential()
	{
		$data["MID"] = "QxXIBI40645275399785";
		$data["INDUSTRY_TYPE_ID"] = "Retail";
		$data["CHANNEL_ID"] = "WEB";
		$data["WEBSITE"] = "DEFAULT";
		return $data;
	}
	
	public function verify_checksum(Request $request)
	{
		$paytmChecksum = "";
		$paramList = array();
		$isValidChecksum = FALSE;

		$paramList = $_POST;
		$return_array = $_POST;
		$paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg

		//Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application’s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
		$isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.

		// if ($isValidChecksum===TRUE)
		// 	$return_array["IS_CHECKSUM_VALID"] = "Y";
		// else
		// 	$return_array["IS_CHECKSUM_VALID"] = "N";
	    echo $isValidChecksum;
		$return_array["IS_CHECKSUM_VALID"] = $isValidChecksum ? "Y" : "N";
		//$return_array["TXNTYPE"] = "";
		//$return_array["REFUNDAMT"] = "";
		unset($return_array["CHECKSUMHASH"]);

		$encoded_json = htmlentities(json_encode($return_array));
		return json_encode($return_array);
	
	}
	public function paytmCallback(Request $request)
	{
		//echo $request['data'];
		if($request['data'])
		{	
		$data=  json_decode($request['data']);
		}
		else
		$data=0;
	    
	    if('TXN_SUCCESS' == $request['STATUS'])
		{
			$gift_last_id 	= $this->get_gift_last_id();
			$gift_id 		= $this->check_gift();
			$get_gift_first_id 		= $this->get_gift_first_id();
			
			
			// if($gift_id ==$gift_last_id)
			// {
				// $gift_id = $this->get_gift_first_id();
			// }
			 if($gift_id ==0 || $gift_id ==11)
			{
				$gift_id = $this->get_gift_first_id();
			}
			// else
			// {
				// $gift_id = $gift_id + 1;
			// }
			
		//echo $gift_id;exit;
			if($request['cart_id'])
				$cart_id = $request['cart_id'];
			else
				$cart_id = 0;
				
			$order  = Order::where('order_id',$data->ORDERID)->first();

		    $order->transaction_id = $data->TXNID;
			if($data->PAYMENTMODE=="UPI")
		    $order->bankname = "UPI";
			else
		    $order->bankname = $data->BANKNAME;
		    $order->payment_mode = $data->PAYMENTMODE;
		    $order->bank_txn_id = $data->BANKTXNID;
		    $order->currency = $data->CURRENCY;
		    $order->gateway_name = $data->GATEWAYNAME;
			$order->status = 'complete';
			$order->gift_id = $gift_id;
			$order->cart_id = $cart_id;
			$order->save();
			
			
			
			// send notification for user
			$user = $this->get_user_email($order->user_id);
			$msg="Hii ".$user->name."<br>Order no: ".$order->order_id."<br>Your order is done successfully";
			$title="Order placed";
			$this->notification($user->firebase_token, $title,$msg);
			$res = $this->send_mobile_message_url($user->contact_no,$msg);
			
			// For user mail
			$this->sendOrderMail($order->order_id,$user->email,$user->name);
			
			// For admin mail
			$admin  = User::find('1');
			$this->sendOrderMail($order->order_id,$admin->other_email,$admin->name);
			
			$msg="Hii Admin <br>Order no: ".$order->order_id."<br>".$user->name."'s order is done successfully";
		    $res = $this->send_mobile_message_url($admin->contact_no,$msg);
			if($user->executive_id!=0)
			{
			//  For executive sms and notification
			$executive = $this->get_user_email($user->executive_id);
			$msg="Hii ".$executive->name."<br>Order no: ".$order->order_id."<br>".$user->name."'s order is done successfully";
			$this->notification($executive->firebase_token, $title,$msg);
			$res = $this->send_mobile_message_url($executive->contact_no,$msg);
			}
			// For manage quantity after order success
			$order_details = OrderDetail::where('order_id',$order->order_id)->get();
			foreach($order_details as $aa)
			{
				$product = Product::find($aa->product_id);
				$product->qty = $product->qty-$aa->qty;
				$product->save();
				
			}
			
			// insert User Wallet
			if($gift_id > 0)
			{
			$gift_thumb = $this->user_wallet($order->user_id,$data->ORDERID,$data->TXNAMOUNT,$gift_id);
			$data1['gift_thumb'] = $gift_thumb;
			}
			// Redeem User Wallet
			if($request['wallet_id'])
			$this->redeem_wallet($request['wallet_id']);
			
			if($cart_id > 0)
			{
				$this->cart_status_update($cart_id,"pending");
			}
			$data1['status'] 				= 'success';
			$data1['gift_thumb'] = $gift_thumb;
			$data1['user_status_message']	= "Order placed successfully";
			$data1['gift_id'] = $order->gift_id;
		
		}
		else
		{
			if($data==null || $data=='')
			{
			$order  = Order::where('order_id',$request->order_id)->first();
			}
		    else
			{
			   $order  = Order::where('order_id',$data->ORDERID)->first();
			}
			$order->status = 'failed';
			$order->order_status = 'failed';
			$order->save();
			$data1['status'] 				= 'failed';
			
			$data1['user_status_message']	= "Order failed";
			
			
		}
		return response()->json($data1);
	}
    ////////////////////////////////////////////////////////////////////////
}
