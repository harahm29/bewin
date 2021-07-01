<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use Session;
use Hash;
use App\User;
use App\VoucherGenerate;
use App\Transaction;
use App\VoucherGenerateDetail;
use App\Mail\InvoicMail;
use App\Slot;
use App\Category;
use App\Subcategory;
use App\AddLotteryTicket;
use App\Lottery;
use App\Winner;
use App\PastWinner;
use DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\Usermail;
use App\Mail\TestAmazonSes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use File;
use Illuminate\Support\Facades\Storage;
ini_set('memory_limit', '-1');
set_time_limit(10000000);
ini_set('max_execution_time', 20000000);
use App\Home;
use App\Content;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function signin()
	{
		if(Auth::check())
			return redirect('/');
        return view('login.login');
    }
    public function signup($referrer=null)
	{
		// if ($request->has('ref')) {
		// 	session(['referrer' => $request->query('ref')]);
		// }
		$data['referrer']='';
		if($referrer){
			$data['referrer']=$referrer;
		}
        return view('login.signup')->with($data);
    }
	public function test_mail()
	{
		if($this->send_user_email("trilok@peninftech.com","Hello","Trilok","Login"))
			echo "success";
		//$this->test_smtp_email();
		Mail::to('trilok@b2infosoft.com')->send(new TestAmazonSes("It works!"));
		
		//$this-> mail_check();
	} 
	 public function mail_check()
  {
	  $to="trilok@peninftech.com";
	  $name="trilok";
	  $from_email = "trilok@peninftech.com";
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Organization: Meridairy \r\n";
		$headers .= "X-Priority: 3\r\n";
		$headers .= "X-Mailer: PHP". phpversion()."\r\n"; 
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= 'From: Meridairy <'.$from_email.'>' . "\r\n";
		$headers .= "Reply-To: <trilok@peninftech.com>\r\n";
		$headers .= "Return-Path: <trilok@peninftech.com>\r\n";
		$headers .= "CC: <trilok@peninftech.com>\r\n";
		$headers .= "BCC: <trilok@peninftech.com>\r\n";
		$current_month = date("M");
		$current_day = date("d");
		$current_year = date("Y");
		///// sending notification email ////
		
		$full_name=ucfirst($name);
	
		$subject ="Order Confirmation Mail";
		
		$msg = 'This is test mail for testing';


		$email_template = $msg;
////////////////////////////////////////////////////////////////////////
	  
	//$headers .= 'Cc: myboss@example.com' . "\r\n";
	$mail = mail($to,$subject,$email_template,$headers);
	if($mail)
	{ 
		echo '<p>Your mail has been sent!</p>';
	} else { 
		echo '<p>Something went wrong, Please try again!</p>'; 
	} 
	//exit;	
	  
  }
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$users  = User::where(['is_deleted'=>0])->where('id','!=',1)->get();
        return view('users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('auth.registration');
    }
	public function register_success()
    {
        return view('login.register-success');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	  private function check_email_id($email,$type)
    {
		return $user = User::where(["email"=>$email,"is_deleted"=>0,'type'=>$type])->count();
	}
    public function store(Request $request)
    {


    $validator = Validator::make($request->all(),[
        'first_name'=>'required|min:2|max:255',
        'last_name'=>'required|min:2|max:255',
        'email'=> 'required|max:255',
        'mobile_no'=>'required|max:255',
        'dob'=>'required|max:255',
        'address'=>'required',
        'password'=>'required',
        'city'=>'required',
        'province'=>'required',
        'postal_code'=>'required|alpha_num',
        'tac'=>'accepted',
    
    ],
	['tac.accepted'=>'Terms And Condition Must Be Accepted']);
	
    if ($validator->fails()) 
		  {
           return back()
               ->withInput()
               ->withErrors($validator);
		  }
		 if($this->check_email_id($request->email,$request->type) > 0)
		{
			return back()
               ->withInput()
               ->with("login_message","Email id already registered");
		}
	//echo "check";exit;
	try{
    $user = new User;
    $user->first_name = ucwords($request->first_name);
    $user->last_name = ucwords($request->last_name);
    $user->type = $request->type;
    $user->mobile_no = $request->mobile_no;
    $user->address = ucfirst($request->address);
    $user->document_id = $request->document_id ?? "";
    $user->document_type = $request->document_type ?? "";
    $user->city = $request->city ?? "";
    $user->province = $request->province ?? "";
    $user->postal_code = $request->postal_code ?? "";
    $user->email = $request->email;
    $user->dob = date('Y-m-d',strtotime($request->dob));
    $user->password = Hash::make($request->password);
    $user->remember_token  = $request->_token;
    $user->token  = $request->_token;
    $user->tac  = $request->tac ?? 0;
    $user->status  =  0;
	$user->username=Str::slug($request->first_name).(User::max('id')+random_int(99, 99999));
	if(isset($request->referrer)){
		$referrer = User::where('username',$request->referrer)->first();
		if($referrer){
			$user->referrer_id 	=$referrer->id;
		}
	}
    if($user->save())
    {
		$type = $request->type;
		if($request->type=='user')
			$subject = "User Verification";
		else
			$subject = "Agent Verification";
		
		$admin_msg = ucwords($user->name)."'s registration has been done in Lottery.";
		
		$msg = "Thank you for registering with us as $type.
		Your login credential is username : ".$user->mobile_no." and password : ".$request->password;
		
		$url=url("verify/".$request->email."/".$request->_token);
		$message = 'Thank you for registering with us as '.$type.'. <br><br>

		Please click here to complete your registration. <br><br>
		<a href="'.$url.'" class="btn btn-success" style="color:#fff;background-color:#dd4b39;border-color:#d73925;display:inline-block;margin-bottom:0;font-weight:400;text-align:center;white-space:nowrap;vertical-align:middle;background-image:none;border:1px solid transparent;padding:6px 12px;font-size:14px;line-height:1.42857143;border-radius:4px;overflow:visible;text-transform:none">Verify Email</a><br><br>
		';
		
		
		//$this->send_user_email($request->email,$message,$user->first_name,$subject);
    return redirect('register-success')->with('message','Thanks for registering with us.Please check your inbox for verification mail which is sent on registered email address.');

    }
}
catch (\Exception $e) {

    return $e->getMessage();
}
    }

    public function dologin(Request $request)
   {
        $validator = Validator::make($request->all(),[
       'email'=> 'required|email',
       'password'=>'required',
       ]);

       if ($validator->fails()) {
         return redirect('login')
           ->withErrors($validator)
           ->withInput();

       }

	$user = User::where(['email'=>$request->email,'is_deleted'=>0,'type'=>$request->type])->first();
	
	// echo "check";exit;
	if($user)
	{
		if($user->status==0)
		{
			return back()->with('login_message', 'Your profile is not verified yet, please check your mail and click on the verification link and then login.');
		}
		else
		{
		   if(Auth::attempt(['email'=>$request->email,'password'=>$request->password, 'status'=>1,'type'=>$request->type,'is_deleted'=>0]))
		   {
				// echo "done";
				// $this->send_user_email("trilok@b2infosoft.com","Good Morning","Trilok","Welcome Message");
				// $this->send_user_email("trilok@peninftech.com","Hello","Trilok","Login");
				// $this->send_user_email("trilok@peninftech.com","Good Morning","Trilok","Welcome Message");
				// exit;
				if(session("back_url"))
				return redirect(session("back_url"))->with('message','You are successfully login');
				else
				return redirect('/')->with('message','You are successfully login');
			   

		   }
		   else
		   {
				   return back()->with('login_message', 'Invalid email and password');
		   }
		}
	}
	else
	{
		return back()->with('login_message', 'Invalid email and password');
	}
}


public function login()
    {

		$home = Home::where(['is_deleted'=>0])->first();
		
		$lotterys = Lottery::select('lotteries.*',DB::raw("time_slots.name as draw_timing"),DB::raw("(select ts.name  from time_slots as ts where ts.id=lotteries.end_lottery_time) as end_time"))
		->leftjoin("time_slots",function($join){
			$join->on("time_slots.id","=","lotteries.draw_timing");
		})
		->where(['lotteries.is_deleted'=>0])
		->where('lotteries.validity','>=',date("Y-m-d"))
		->orderBy('lotteries.id','desc')
		->get();
		
		$winners = AddLotteryTicket::select("add_lottery_tickets.*",DB::raw("concat(users.first_name,users.last_name) as name"),DB::raw("lotteries.image as lottery_image"),DB::raw("lotteries.cat1_val as cat1_val"))
					->leftjoin("users",function($join){
						$join->on("users.id","=","add_lottery_tickets.user_id");
					})
					->leftjoin("lotteries",function($join){
						$join->on("lotteries.id","=","add_lottery_tickets.lottery_id");
					})
					->groupBy('today_date','lottery_id')
					->where(['add_lottery_tickets.is_deleted'=>0])
					->orderBy("add_lottery_tickets.id","desc")->limit(10)->paginate(10);
		$pastwinners = PastWinner::select('past_winners.*',DB::raw("lotteries.name as lottery_name"),DB::raw("lotteries.image as lottery_image"))
						->leftjoin("lotteries",function($join){
							$join->on("lotteries.id","=","past_winners.lottery_id");
						})
						->where(['past_winners.is_deleted'=>0])
						->orderBy('past_winners.id','desc')->limit(10)->paginate(10);
					// echo "<pre>";
					// print_r($pastwinners);exit;
					
        return view('auth.login',compact('home','lotterys','winners','pastwinners'));
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
		if($user->status==1)
			$status ='<p class="text-success" >Active</p>';
		else
			$status ='<p class="text-danger" >Inactive</p>';
		
		$to = \Carbon\Carbon::createFromFormat('Y-m-d',date("Y-m-d"));
		$from = \Carbon\Carbon::createFromFormat('Y-m-d',$user->activate_end_date);
		$diff_in_days = $to->diffInDays($from);
		if($diff_in_days < 0)
		$diff_in_days = 0;
		// print_r($diff_in_days); // Output: 1

		$output= '';
		$output.= '  
		<div  class="table-responsive">  
          <table align="center" class="table table-bordered">';  
     
 
 
          $output .= '  
               <tr>  
                    <td width="30%"><label>First Name</label></td>  
                    <td width="70%">'.ucfirst($user->first_name).'</td>  
               </tr>
			   <tr>  
                    <td width="30%"><label>Last Name</label></td>  
                    <td width="70%">'.ucfirst($user->last_name).'</td>  
               </tr>
			   <tr>  
                    <td width="30%"><label>Email</label></td>  
                    <td width="70%">'.$user->email.'</td>  
               </tr>
			   <tr>  
                    <td width="30%"><label>Contact No</label></td>  
                    <td width="70%">'.$user->mobile_no.'</td>  
               </tr>
			   <tr>  
                    <td width="30%"><label>Dob</label></td>  
                    <td width="70%">'.date("d-M-Y",strtotime($user->dob)).'</td>  
               </tr>
			  
			   <tr>  
                    <td width="30%"><label>Remaining days</label></td>  
                    <td width="70%">'.$diff_in_days.'</td>  
               </tr>
			  
			   <tr>  
                    <td width="30%"><label>Status</label></td>  
                    <td width="70%">'.$status.'</td>  
               </tr>
			   
			   ';
	
     $output .= "</table></div>";  
     echo $output; 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
		$user->is_deleted = 1;
		if($user->save())
		{
			return back()->with('message','User Deleted Successfully');
		}
    }
	public function update_status(Request $request)
	{
		
		if($request->type=="users")
		{
			$user = User::where('id',$request->id)->first();
			$user->status = $request->status;
		}
		else if($request->type=="slots")
		{
			$user = Slot::where('id',$request->id)->first();
			$user->status = $request->status;
		}
		else if($request->type=="category")
		{
			$user = Category::where('id',$request->id)->first();
			$user->status = $request->status;
		}
		else if($request->type=="subcategory")
		{
			$user = Subcategory::where('id',$request->id)->first();
			$user->status = $request->status;
		}
		if($user->save())
		{
			 session()->put('success','Status change successfully');
			 echo "yes";
		}
		else{
			session()->put('warning','Status not change successfully');
			 echo "no";
		}
	}
	public function profile() 
    {
       return view('dashboard.profile');
    }
	public function add_money() 
    {
       return view('dashboard.add_money');
    }
///////Check User Token
public function user_money (Request $request)
{
$validator = Validator::make($request->all(),[
       'voucher'=> 'required',
      // 'amount'=>'required',
       ]);

       if ($validator->fails()) {
         return redirect('add-money')
           ->withErrors($validator)
           ->withInput();

       }
 $VoucherGenerate =VoucherGenerate::where(['voucher'=>$request->voucher,'status'=>0])->first() ;
 $VoucherGenerateDetail =VoucherGenerateDetail::where(['voucher'=>$request->voucher,'status'=>0])->first() ;
if($VoucherGenerate)
{
$VoucherGenerates = 	$VoucherGenerate->amount; 
}
if($VoucherGenerateDetail)
{
$VoucherGenerates = 	$VoucherGenerateDetail->amount;	
}
 if($VoucherGenerate != '')
     {
      $amount = New Transaction;
	  $amount->user_id = Auth::user()->id;
	  $amount->cr = $VoucherGenerates ?? '0:00';
	  $amount->transaction_date = date('Y-m-d');
	  $amount->today_date = date('Y-m-d');
	  $amount->description ='Amount Add By User';
	  $amount->party_name = Auth::user()->first_name;
	  $amount->sales_ledger = Auth::user()->first_name;
	  $amount->form_name = 'Add Money';
	  $amount->p_type = 'add_money';
	  $amount->comment = 'Amount Add By User';
	  $amount->save();
	 
	     $VoucherGenerate =VoucherGenerate::where(['voucher'=>$request->voucher,'status'=>0])->first();
		 $VoucherGenerate->status = '1';
		 $VoucherGenerate->user_id = Auth::user()->id;
		 $VoucherGenerate->save();
		  return redirect('add-money')->with('message','Amount Add Successfully');
	  } 
	   if($VoucherGenerateDetail != '')
     {
      $amount = New Transaction;
	  $amount->user_id = Auth::user()->id;
	  $amount->cr = $VoucherGenerates ?? '0:00';
	  $amount->transaction_date = date('Y-m-d');
	  $amount->today_date = date('Y-m-d');
	  $amount->description ='Amount Add By User';
	  $amount->party_name = Auth::user()->first_name;
	  $amount->sales_ledger = Auth::user()->first_name;
	  $amount->form_name = 'Add Money';
	  $amount->p_type = 'add_money';
	  $amount->comment = 'Amount Add By User';
	  $amount->save();
	 
	     
	     $VoucherGenerateDetail =VoucherGenerateDetail::where(['voucher'=>$request->voucher,'status'=>0])->first();
		 $VoucherGenerateDetail->status = '1';
		 $VoucherGenerateDetail->user_id = Auth::user()->id;
		 $VoucherGenerateDetail->save();
		 return redirect('add-money')->with('message','Amount Add Successfully');
	  } 
	 
	 else
	 {
	  return redirect('add-money')->with('message','Please Insert Correct Voucher Number ');
	 }
	
}






    public function update_profile(Request $request)
    {
		// echo "<pre>";\
		// print_r($_POST);
		// exit;
        $validator = Validator::make($request->all(),[
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'mobile_no' => 'required',
			'dob'=>'required|max:255',
            'address'=>'required',
            'city'=>'required',
            'province'=>'required',
            'postal_code'=>'required',
            
        ]);
		$user = User::find(Auth::user()->id);
        if($validator->fails())
        {
            return redirect('profile')
            ->withInput()
            ->withErrors($validator);
        }
		
		if($request->hasFile('user_image') && $request->user_image->isValid())
           {     
               $extension = $request->user_image->extension();
               $fileName  = "image".time().".$extension";
               $request->user_image->move(public_path('images'),$fileName);
           }
           else
           {
               $fileName = $user->user_image;
           }
        
        $user->first_name = ucwords($request->first_name);
        $user->last_name = ucwords($request->last_name);
        $user->mobile_no = $request->mobile_no;
        $user->address = ucfirst($request->address);
        $user->document_id = $request->document_id ?? "";
        $user->document_type = $request->document_type ?? "";
        $user->city = $request->city ?? "";
        $user->province = $request->province ?? "";
        $user->postal_code = $request->postal_code ?? "";
        $user->dob = date('Y-m-d',strtotime($request->dob));
		
        $user->user_image = $fileName;
		
		
        if($user->save())
        {
            return redirect('profile')->with('message','Profile updated successfully');
        }
        else{

            return redirect('profile')->with('message','Profile not updated successfully');
        }
    }
	//////////////////////////////////////////////////
	
	public function logout()
	{
		Session::forget('back_url');
		Auth::logout();
		return redirect('/');
	}
	public function showchangepasswordform()
	{
		$user = User::find(Auth::user()->id);
		     return view('dashboard.change-password',compact('user'));
	}
	
	 public function changepassword(Request $request)
    {
        
        $validator = Validator::make($request->all(),[
            'new_password' => ['required'],
            'confirm_password' =>['same:new_password'],
        ]);
		if($validator->fails())
			{
				return back()
				->withInput()
				->withErrors($validator);
			}
		$user = User::find(Auth::user()->id);
       User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
      Session::flash('message','Thank you !Your password is changed successfuly.'); 
        return back();
    }	
	
	/////////////For Forget Password////////////
	/////////////For Forget Password////////////
	public function forget_password_show(Request $request)
	{
		// echo "check";exit;
		return view('login.forget-password');
	}
	public function forget_password(Request $request)
	{
		// echo "check";exit;
		$validator = Validator::make($request->all(),[
		'email'=>'required',
		],[
		'email.required'=>'Please provide E-mail first'
		]);
		if($validator->fails())
			{
				return back()
				->withInput()
				->withErrors($validator);
			}

		  $user = User::where(['email'=>$request->email,'is_deleted'=>0])->where('id','!=',1)->first();
		  // echo "<pre>";
		  // print_r($user);
		  // exit;
		  if($user)
		  {
			   $digits = 6;
			   $pass = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
			   
			   $url=url("signin");
		$message = 'Your New Password is $pass<br><br>

Please click here to login our website. <br><br>
<a href="'.$url.'" class="btn btn-success" style="color:#fff;background-color:#dd4b39;border-color:#d73925;display:inline-block;margin-bottom:0;font-weight:400;text-align:center;white-space:nowrap;vertical-align:middle;background-image:none;border:1px solid transparent;padding:6px 12px;font-size:14px;line-height:1.42857143;border-radius:4px;overflow:visible;text-transform:none">Click Here !!</a><br><br>
';
		
			 
			   // $user->password = Hash::make($request->pass);
			   // $user->save();
			   User::where(['email'=>$request->email])->update(['password'=>Hash::make($request->pass)]);
			
			  //$res = $this->send_mobile_message_url($user->mobile_no,$message);
			  $subject = "Forgot Password";
			
			$this->send_user_email($user->email,$message,$user->first_name,$subject);
			  return redirect('/signin')->with('message','Your password is successfully send on your email address.');
		  }
		  else{
			   return back()->with('login_message','Please enter correct email address')->withInput();
		  }

	}
	
/////SEND USER Email	
	public function send_user_email($email,$msg,$name,$subjects)
		{ 
	     
	    // Mail::to($email)
		// ->send(new Usermail($msg,$name,$subject));
	
		$from_email = "bewin@bewin.one";
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Organization: esorthodontics \r\n";
		$headers .= "X-Priority: 3\r\n";
		$headers .= "X-Mailer: PHP". phpversion()."\r\n"; 
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= 'From: <'.$from_email.'>' . "\r\n";
		$headers .= "Reply-To: <bewin@bewin.one>\r\n";
		$headers .= "Return-Path: <bewin@bewin.one>\r\n";
		$headers .= "CC: <bewin@bewin.one>\r\n";
		$headers .= "BCC: <bewin@bewin.one>\r\n";
		$current_month = date("M");
		$current_day = date("d");
		$current_year = date("Y");
		///// sending notification email ////
	   $to=$email;
		$subject =$subjects;
        $imagepath = url('/').'public/images/b2_logo.png';
          $email_template = '';
		$url = url('/');
		$email_template .= '<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" style="background-color:#CCCCCC; padding-top:20px; padding-bottom:20px;"><table width="720" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td style="background-color:#FFFFFF;"><table width="670" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="169" height="20">&nbsp;</td>
            <td width="501">&nbsp;</td>
          </tr>
          <tr>
            <td><a href="'.$imagepath.'" target="_blank"><img src="'.$imagepath.'" alt="" border="0" height="80" /></a></td>
            <td align="right" style="font-family:Arial, Helvetica, sans-serif;"><strong>Date</strong><br />'. $current_month.' '.$current_day.', '.$current_year.'</td>
          </tr>
          <tr>
            <td style="height:20px; border-bottom:1px solid #CCCCCC;">&nbsp;</td>
            <td style="border-bottom:1px solid #CCCCCC;">&nbsp;</td>
          </tr>
          <tr>
            <td style="height:20px;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
          <table width="670" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td style="font-family:Arial, Helvetica, sans-serif;"><p>Dear '.$name.' </p>
			<p>'.$msg.'</p><br/></td>
            </tr>
            <tr>
              <td style="font-family:Arial, Helvetica, sans-serif;"><br />
			  Thanks,<br />
			  Bewin.one team<br/>
			  <a href="'.$url.'">"'.$url.'"</a>
			  <br/>
			  <br/>
			  </td>
            </tr>
            <tr>
              <td style="border-top:1px solid #CCCCCC; padding-top:15px;"><table border="0" cellspacing="0" cellpadding="0">
                <tr>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td height="20">&nbsp;</td>
            </tr>
          </table></td>
      </tr>
    </table>
      <table width="720" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td style="text-align:center; padding-top:15px; font-family:Arial, Helvetica, sans-serif; font-size:11px;">
            
            
          </td>
        </tr>
      </table></td>
  </tr>
</table>
';
////////////////////////////////////////////////////////////////////////
	  
	//$headers .= 'Cc: myboss@example.com' . "\r\n";
	$mail = mail($to,$subject,$email_template,$headers);
	if($mail)
	{ 
		echo '<p>Your mail has been sent!</p>'; 
	} else { 
		echo '<p>Something went wrong, Please try again!</p>'; exit;
	}
					
    }
	
	public function sendRequest($uri){
      $curl = curl_init($uri);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
      $response = curl_exec($curl);
      curl_error($curl);
      curl_errno($curl);
      curl_close($curl);
     if ($response === false) {
        $res= ('failed to initialize');
    }
      return $response;
  }

 public function send_mobile_message_url($phone,$message)
  {
      $message = str_replace(' ', '+', $message);  
        $message = str_replace("<br>","%0a",$message);    
  
        	//मेरी+डेयरी
  		$uri ="http://sms.b2infosoft.com/api/sendmsg.php?user=khokhar&pass=yJG36OKJlNJhRZ58&sender=MDAIRY&phone=$phone&text=$message&priority=ndnd&stype=normal";
    
    //file_get_contents($uri);
    return $this->sendRequest($uri);
   }  
    
public function send_mail()
{
$user_emails = User::select('email','id')->where(['is_deleted'=>0,'type'=>'teacher'])->get();
foreach($user_emails as $user_email)
{	
Mail::to($user_email->email)->send(new InvoicMail($user_email->id));
} 
}	
// Send notification
	public function notification_show(Request $request)
	{
		return view('users.notification');
		
	} 
	public function send_notification_users(Request $request)
	{
		
		$validator = Validator::make($request->all(),[
            'description' => 'required',
        ]);
        if($validator->fails())
        {
            return back()
            ->withInput()
            ->withErrors($validator);
        }
		if($request->hasFile('image') && $request->image->isValid())
	    {
					$file = $request->file('image');
				   $name = "image".time() . $file->getClientOriginalName();
				   $filePath = 'images/' . $name;
				   $disk = Storage::disk('s3');
				   $disk->put($filePath, fopen($file, 'r+'), 'public');
				   $fileName = $name;
		}
		else
		{
			$fileName  ='default.jpg';
		}
		
		$title="B2STUDIES";
		
		$user = User::where(['is_deleted'=>0,'type'=>'user'])->where('firebase_token','!=','')->get();
		 
		  foreach ($user as $key => $value) {
			$this->notification($value->firebase_token, $title,$request->description,"login",$fileName);
        }

		return back()->with('message','Notification Successfully send to all users');
	}	
	
	 public function notification($token, $title, $description,$type,$fileName)
    {
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $token=$token;
		$url = AWS_CLOUD."images/".$fileName; 
        $notification = [
            'title' => $title,
			'description'=>$description,
			'type'=>$type,
			//'data'=>$data,
			'image'=>$url,
            'sound' => true,
        ];
        
       $extraNotificationData = ["data" => $notification];

        $fcmNotification = [
            //'registration_ids' => $tokenList, //multple token array
            'to'        => $token, //single token
            'data' => $notification
        ];

        $headers = [
            'Authorization: key=AAAAocj-NUA:APA91bFxgTHIsDWr-6MkcSH6b0KiV4RIQlypAKE6mxDraTGQcaQ2b_2fNhG1_s4OuuQ0AYMXtKrsycOrPp3Avocteqp8kI6I43rWgo3n-UX5nLZketrlPTaagfE9K_df_YMf9hyh98WZ',
            'Content-Type: application/json'
        ];

        


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
	   
	   
        curl_close($ch);

        return true;
    }
	public function verifyUser($email,$token)
    {
   // echo $email;exit;
    $user = User::where(['email'=>$email,'token'=>$token])->first();
	
	
    if($user)
    {
        $user->token='';
        $user->status=1;
        if($user->save())
        {
			$title="Verification";
			$type="verify";
			$description="Your account verified and activated";
			//$this->notification($user->firebase_token, $title,$description,$type);
		
			$msg ="Your account verified and activated.<br/>
				You can place your orders & payments on Apps.<br/><br/>

				Enjoy Bucketful of benefits.<br/>
				For any other assistance feel free to contact our team.<br/><br/>

				Thanks you";
			$subject="User Verification";
			$this->send_user_email($user->email,$msg,$user->name,$subject);
			$txtmsg ="Your account verified and activated. You can place your orders and payment on Apps.Enjoy Bucketful of benefits. For any other assistance feel free to contact our team. Thank you";
			
		//	$res = $this->send_mobile_message_url($user->contact_no,$txtmsg);
            return redirect('/signin')->with('message','Your account verified successfully');
			
        }
        else
        {
		//	echo "no";exit;
            return redirect('/')->with('message','Invalid token or email');
        }
    }
    else
    {
         return redirect('/')->with('message','Invalid token or password');
    }
    }
	public function my_history(Request $request)
	{
		
		if($request->from)
        {
			// echo "1"; exit;
		  $from_date = date("Y-m-d",strtotime($request->from)); 
		  $to_date  =  date("Y-m-d",strtotime($request->to));
		  
		 $lotterys = AddLotteryTicket::select("add_lottery_tickets.*",DB::raw("winners.winning_category"),DB::raw("winners.winning_price"))
						 ->leftjoin("winners",function($join){
							 $join->on("winners.id","=","add_lottery_tickets.win_id");
						 })
						 ->where(['add_lottery_tickets.is_deleted'=>0,'add_lottery_tickets.status'=>1])
						->whereBetween('add_lottery_tickets.today_date', [$from_date,$to_date])
						->orderBy('add_lottery_tickets.id','desc')->paginate(10);
		
		}
		else
		{
	// echo "2"; exit;
			 $from_date = date("Y-m-01"); 
		     $to_date  =  date("Y-m-d");
			 
			$lotterys = AddLotteryTicket::select("add_lottery_tickets.*",DB::raw("winners.winning_category"),DB::raw("winners.winning_price"))
							->leftjoin("winners",function($join){
							   $join->on("winners.id","=","add_lottery_tickets.win_id");
						     })
						 ->where(['add_lottery_tickets.is_deleted'=>0,'add_lottery_tickets.status'=>1])
						 ->orderBy('add_lottery_tickets.id','desc')->paginate(10);
		}
		return view('users.my-history',compact("lotterys",'from_date','to_date'));
	}
	//////////////////////////////////////////////////////////////////////////////////////////////////
}
