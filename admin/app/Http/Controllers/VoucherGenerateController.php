<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\Usermail;
use App\Mail\Voucher;
use App\VoucherGenerate;
use App\User;
use App\VoucherGenerateDetail;
use Illuminate\Http\Request;
use Auth;
use Validator;
use DB;
use Session;
class VoucherGenerateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
	
	   $users  = User::where(['is_deleted'=>0,'type'=>'agent'])->where('id','!=',1)->get();
	   $voucherGenerate = VoucherGenerate::where(['status'=>0])->get();
       return view('vouchergenerate.index',compact('voucherGenerate','users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
	  $users  = User::where(['is_deleted'=>0,'type'=>'agent'])->where('id','!=',1)->get();
	  // echo "<pre>";
	  // print_r($users); exit;
      return view('vouchergenerate.create',compact('users'));
    }
 ///////////////////FOR INVOICE
  public function invoice_voucher($id)
    {
   $voucherGenerates = VoucherGenerate::where('id','=',$id)->where('status','=',0)->first();
   $voucherGeneratedetails = DB::table('voucher_generates')
            ->join('voucher_generate_details', 'voucher_generates.id', '=', 'voucher_generate_details.voucher_id')
            ->select('voucher_generate_details.*')
			->where('voucher_generate_details.voucher_id',$id)
			->where('voucher_generate_details.status','=',0)
			->where('voucher_generates.status','=',0)
            ->get();
		return view('vouchergenerate.voucher',compact('voucherGenerates','voucherGeneratedetails'));
	}
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
	    $useremail = User::where('id','=',$request->agent_id)->first();
	  	$email = $useremail->email; 
		$name = $useremail->first_name; 
		$subject ="Lottery Voucher";
		
         $voucherGenerate = New VoucherGenerate;
		$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJQLMNOPQRSTUVWXYZ';
		 $random_character_single =substr(str_shuffle($permitted_chars), 0,16);
		
		 $voucherGenerate->amount = $request->amount;
		 $voucherGenerate->agent_id = $request->agent_id;
		 $voucherGenerate->voucher_date = date('Y-m-d');
		 $voucherGenerate->voucher_number = $request->voucher_number;
		 $voucherGenerate->voucher = $random_character_single;
		 $voucherGenerate->save();
		 
		 $strength =$request->voucher_number;
		$random_string = '';
			for($i = 1; $i < $strength; $i++) {
				$random_character = substr(str_shuffle($permitted_chars), 0,16);
			
		 $VoucherGenerateDetail = New VoucherGenerateDetail;
         $VoucherGenerateDetail->voucher_id = $voucherGenerate->id;
         $VoucherGenerateDetail->amount = $request->amount;;
         $VoucherGenerateDetail->voucher_date = date('Y-m-d');
         $VoucherGenerateDetail->agent_id = $request->agent_id;
		 $VoucherGenerateDetail->voucher_number = $request->voucher_number;
		 $VoucherGenerateDetail->voucher = $random_character;
         $VoucherGenerateDetail->save();
		 
			}
			
   $voucherGenerates = VoucherGenerate::where('id','=',$voucherGenerate->id)->where('status','=',0)->first();
   $voucherGeneratedetails = DB::table('voucher_generates')
            ->join('voucher_generate_details', 'voucher_generates.id', '=', 'voucher_generate_details.voucher_id')
            ->select('voucher_generate_details.*')
			->where('voucher_generate_details.voucher_id',$voucherGenerate->id)
			->where('voucher_generate_details.status','=',0)
			->where('voucher_generates.status','=',0)
            ->get();
			// $this->send_mail($email,$voucherGenerates,$voucherGeneratedetails,$subject);
		  Mail::to($email)->send(new Voucher($voucherGenerates,$voucherGeneratedetails,$subject));
		 return redirect('voucher-Generate')->with('message','Voucher Generate Successfully');
    }
	
	
 
    /**
     * Display the specified resource.
     *
     * @param  \App\VoucherGenerate  $voucherGenerate
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
   $voucherGenerates = VoucherGenerate::where('id','=',$id)->first();
   $voucherGeneratedetail = DB::table('voucher_generates')
            ->join('voucher_generate_details', 'voucher_generates.id', '=', 'voucher_generate_details.voucher_id')
            ->select('voucher_generate_details.*')
			->where('voucher_generate_details.voucher_id',$id)
            ->get();
  // echo "<pre>";
  // print_r($voucherGeneratess); exit;
		$output='';
		$output.= '<table border="0" align="center" class="table"> 
                    <tr>  
                    <td ><label>Amount</label></td>
					<td  colspan="2">$ '.$voucherGenerates->amount.'</td> </tr>
					
					<tr>  
                    <td ><label>Voucher Number</label></td>
                    <td colspan="2">'.$voucherGenerates->voucher_number.'</td>
					</tr>
					<tr>  
                    <td ><label>Voucher</label></td>
                    <td colspan="2">'.$voucherGenerates->voucher.'</td>
					</tr>'; 
					foreach($voucherGeneratedetail as $voucherGeneratedetails){
					$output .='<tr>
					
                       <td ><label>Voucher</label></td>
					   <td colspan="2">'.$voucherGeneratedetails->voucher.'</td>  
					
                     </tr>';
					}
					$output .='</table>';  
                    return $output; 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\VoucherGenerate  $voucherGenerate
     * @return \Illuminate\Http\Response
     */
    public function edit(VoucherGenerate $voucherGenerate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VoucherGenerate  $voucherGenerate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VoucherGenerate $voucherGenerate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\VoucherGenerate  $voucherGenerate
     * @return \Illuminate\Http\Response
     */
public function send_mail($email,$voucherGenerates,$voucherGeneratedetails,$subject)
{
$from_email = "bewin@bewin.one";
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Organization: esorthodontics \r\n";
		$headers .= "X-Priority: 3\r\n";
		$headers .= "X-Mailer: PHP". phpversion()."\r\n"; 
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= 'From: bewin.one <'.$from_email.'>' . "\r\n";
		$headers .= "Reply-To: <bewin@bewin.one>\r\n";
		$headers .= "Return-Path: <bewin@bewin.one>\r\n";
		$headers .= "CC: <bewin@bewin.one>\r\n";
		$headers .= "BCC: <bewin@bewin.one>\r\n";
	$to = $email;	
$subject = $subject;
$voucher = array();
foreach($voucherGeneratedetails as $voucherGeneratedetail)
{
	$voucher = $voucherGeneratedetail->voucher;
}
$txt ='<html>
<head>
    <meta charset="utf-8">
    <title>Voucher Number</title>
    <style>
    .invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 16px;
        line-height: 24px;
        font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
        color: #555;
    }
    
    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }
    
    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }
    
    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }
    
    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }
    
    .invoice-box table tr.information table td {
        padding-bottom: 40px;
    }
    
    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }
    
    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
    }
    
    .invoice-box table tr.item.last td {
        border-bottom: none;
    }
    
    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }
    
    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }
        
        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }
    
    /** RTL **/
    .rtl {
        direction: rtl;
        font-family: Tahoma, "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
    }
    
    .rtl table {
        text-align: right;
    }
    
    .rtl table tr td:nth-child(2) {
        text-align: left;
    }
    </style>
</head>

<body>
<h3 style="text-align: center;">BEWIN.ONE</h3>
    <div class="invoice-box">
	
        <table cellpadding="0" cellspacing="0">
            
            <tr class="heading">
                <td>
                    Payment
                </td>
                
                <td>
                    Date
                </td>
            </tr>
            
            <tr class="details">
                <td>
				$ '.$voucherGenerates->amount.'
                </td>
                
                <td>
                   '.$voucherGenerates->voucher_date.'
				  </td>
            </tr>
            
            <tr class="heading">
                <td>
                Voucher Number
                </td><td>
               
                </td>
            </tr>
			<tr class="item">
                <td>
                   Voucher Number
                </td>
                
                <td>
				'.$voucherGenerates->voucher.'
                </td>
            </tr>
         
            <tr class="item">
                <td>
                   Voucher Number
                </td>
                
                <td>
				'.$voucher.'
                </td>
            </tr>
		   
           
       </table>
    </div>

</body>
</html>';


//$headers .= 'Cc: myboss@example.com' . "\r\n";
	$mail = mail($to,$subject,$txt,$headers);
	if($mail)
	{ 
		echo '<p>Your mail has been sent!</p>'; 
	} else { 
		echo '<p>Something went wrong, Please try again!</p>'; 
	}
		
}
    public function destroy(VoucherGenerate $voucherGenerate)
    {
        //
    }
}
