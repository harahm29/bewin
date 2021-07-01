<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use Session;
use Hash;
use App\User;
use App\Mail\InvoicMail;
use App\Slot;
use App\Category;
use App\WinningNumber;
use App\Subcategory;
use App\Voucher;
use App\Commission;
use App\Lottery;
use App\AddLotteryTicket;
use App\Transaction;
use DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\Usermail;
use App\Mail\TestAmazonSes;
use App\Winner;
use App\UserFreeTicket;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use File;
use DateTime;
use Illuminate\Support\Facades\Storage;
ini_set('memory_limit', '-1');
set_time_limit(10000000);
ini_set('max_execution_time', 20000000);
class UserController extends Controller
{
	 
	public function test_mail()
	{
		if($this->send_user_email("trilok@b2infosoft.com","Hello","Trilok","Login"))
			echo "success";
		//$this->test_smtp_email();
		Mail::to('trilok@b2infosoft.com')->send(new TestAmazonSes("It works!"));
	}
	function test_smtp_email()
	{
		
		// Import PHPMailer classes into the global namespace
		// These must be at the top of your script, not inside a function
		

		// If necessary, modify the path in the require statement below to refer to the
		// location of your Composer autoload.php file.
		

		// Replace sender@example.com with your "From" address.
		// This address must be verified with Amazon SES.
		$sender = 'info@b2studies.com';
		$senderName = 'B2STUDIES';

		// Replace recipient@example.com with a "To" address. If your account
		// is still in the sandbox, this address must be verified.
		$recipient = 'trilok@peninftech.com';

		// Replace smtp_username with your Amazon SES SMTP user name.
		$usernameSmtp = 'AKIAVN4IKLGK6FA7LYJ6';

		// Replace smtp_password with your Amazon SES SMTP password.
		$passwordSmtp = 'KlhMVuJCjPxgmQ4XU8zshe+Hl5gOyl1APuZJ5rgv';

		// Specify a configuration set. If you do not want to use a configuration
		// set, comment or remove the next line.
		$configurationSet = 'b2studies'; //b2studies

		// If you're using Amazon SES in a region other than US West (Oregon),
		// replace email-smtp.us-west-2.amazonaws.com with the Amazon SES SMTP
		// endpoint in the appropriate region.
		// $host = 'email-smtp.us-west-2.amazonaws.com';
		$host = 'email-smtp.ap-south-1.amazonaws.com';
		$port = 587;

		// The subject line of the email
		$subject = 'Amazon SES test (SMTP interface accessed using PHP)';

		// The plain-text body of the email
		$bodyText =  "Email Test\r\nThis email was sent through the
			Amazon SES SMTP interface using the PHPMailer class.";

		// The HTML-formatted body of the email
		$bodyHtml = '<h1>Email Test</h1>
			<p>This email was sent through the
			<a href="https://aws.amazon.com/ses">Amazon SES</a> SMTP
			interface using the <a href="https://github.com/PHPMailer/PHPMailer">
			PHPMailer</a> class.</p>';

		$mail = new PHPMailer(true);

		try {
			// Specify the SMTP settings.
			$mail->isSMTP();
			$mail->setFrom($sender, $senderName);
			$mail->Username   = $usernameSmtp;
			$mail->Password   = $passwordSmtp;
			$mail->Host       = $host;
			$mail->Port       = $port;
			$mail->SMTPAuth   = true;
			$mail->SMTPSecure = 'tls';
			$mail->addCustomHeader('X-SES-CONFIGURATION-SET', $configurationSet);

			// Specify the message recipients.
			$mail->addAddress($recipient);
			// You can also add CC, BCC, and additional To recipients here.

			// Specify the content of the message.
			$mail->isHTML(true);
			$mail->Subject    = $subject;
			$mail->Body       = $bodyHtml;
			$mail->AltBody    = $bodyText;
			$mail->Send();
			echo "Email sent!" , PHP_EOL;
		} catch (phpmailerException $e) {
			echo "An error occurred. {$e->errorMessage()}", PHP_EOL; //Catch errors from PHPMailer.
		} catch (Exception $e) {
			echo "Email not sent. {$mail->ErrorInfo}", PHP_EOL; //Catch errors from Amazon SES.
		}
		//exit;
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$type="User";
		$users  = User::where(['is_deleted'=>0,'type'=>'user'])->where('id','!=',1)->get();
        return view('users.index',compact('users','type'));
    } 
	public function agent(Request $request)
    {
		$type="Agent";
		$users  = User::where(['is_deleted'=>0,'type'=>'agent'])->where('id','!=',1)->get();
        return view('users.index',compact('users','type'));
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

           

        $validator = Validator::make($request->all(),[
    'name'=>'required|min:2|max:255',
    'email'=> 'required|unique:users|max:255',
    'mobile_no'=>'required|unique:users|max:255',
    'address'=>'required',
    'password'=>'required',
    
    ]);
    if($validator->fails()){
      return redirect('/user/create')
      ->withInput()
      ->withError($validator);
    }

    $user = new User;
    $user->name = $request->name;
    $user->email = $request->email;
     $user->mobile_no = $request->mobile_no;
     $user->address = $request->address;
     $user->password = Hash::make($request->password);
      $user->remember_token  = $request->_token;

     
    
    
    $user->save();
    session::flash('message','Thank you !Your Registration is complete successfuly.');
    return redirect('login');
    
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


   if(Auth::attempt(['email'=>$request->email,'password'=>$request->password, 'status'=>1,'type'=>'admin','id'=>1]))
   {

        return redirect('dashboard');


   }

   else{
           return back()->with('message', 'Invalid email and password');
   }
}


public function login()
    {
        //
        return view('auth.login');
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
		
		
		// print_r($diff_in_days); // Output: 1

		$output= '';
		$output.= '  
		<div  class="table-responsive">  
          <table align="center" class="table table-bordered">';  
     
 
 
          $output .= '  
               <tr>  
                    <td width="30%"><label>Full Name</label></td>  
                    <td width="70%">'.ucfirst($user->first_name).' '.ucfirst($user->last_name).'</td>  
               </tr>
			   <tr>  
                    <td width="30%"><label>Email</label></td>  
                    <td width="70%">'.$user->email.'</td>  
               </tr>
			   
			   <tr>  
                    <td width="30%"><label>Dob</label></td>  
                    <td width="70%">'.date("d-M-Y",strtotime($user->dob)).'</td>  
               </tr>
			   <tr>  
                    <td width="30%"><label>Mobile No</label></td>  
                    <td width="70%">'.$user->mobile_no.'</td>  
               </tr>
			   <tr>  
                    <td width="30%"><label>City</label></td>  
                    <td width="70%">'.$user->city.'</td>  
               </tr>
			   <tr>  
                    <td width="30%"><label>Postal Code</label></td>  
                    <td width="70%">'.$user->postal_code.'</td>  
               </tr> 
			   <tr>  
                    <td width="30%"><label>Province</label></td>  
                    <td width="70%">'.$user->province.'</td>  
               </tr>
			   <tr>  
                    <td width="30%"><label>Document Type</label></td>  
                    <td width="70%">'.ucfirst(str_replace("_"," ",$user->document_type)).'</td>  
               </tr> 
			   <tr>  
                    <td width="30%"><label>Document Id</label></td>  
                    <td width="70%">'.$user->document_id.'</td>  
               </tr> 
			   <tr>  
                    <td width="30%"><label>Address</label></td>  
                    <td width="70%">'.$user->address.'</td>  
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
	
	public function profile() 
    {
       return view('dashboard.profile');
    }
    public function update_profile(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'name' => 'required|max:255',
            'mobile_no' => 'required|max:255',
            //'email' => 'required|unique:users|email',
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
        
        $user->name = $request->name;
        $user->mobile_no = $request->mobile_no;
		//if($request->email!=$user->email)
        $user->email = $request->email;
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
		Auth::logout();
		return redirect('/');
	}
	public function showchangepasswordform()
	{
		$user = User::find(Auth::user()->id);
		     return view('auth.changepassword',compact('user'));
	}
	
	 public function changepassword(Request $request)
    {
        
        $validator = Validator::make($request->all(),[
            'new_password' => ['required'],
            'confirm_password' =>['same:new_password'],
        ]);
		$user = User::find(Auth::user()->id);
       User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
      Session::flash('message','Thank you !Your password is changed successfuly.'); 
        return redirect('/dashboard');
    }	
	
	/////////////For Forget Password////////////
	public function forget_password(Request $request)
	{
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
			   $message = "Hello ".ucwords($user->name)."<br>Your New Password is $pass";
			 
			   // $user->password = Hash::make($request->pass);
			   // $user->save();
			   User::where(['email'=>$request->email])->update(['password'=>Hash::make($request->pass)]);
			
			  //$res = $this->send_mobile_message_url($user->mobile_no,$message);
			  $subject = "Forgot Password";
			
			  $this->send_user_email($user->email,$message,$user->name,$subject);
			  return redirect('/')->with('message','Your password is successfully send on your email address.');
		  }
		  else{
			   return back()->with('errorMsg','Please enter correct email address');
		  }

	}
	public function send_user_email($email,$msg,$name,$subject)
	{
		Mail::to($email)
		->send(new Usermail($msg,$name,$subject));
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
	
	 public function notification($token, $title, $description,$type,$fileName=null)
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
	public function update_status(Request $request)
	{
		
		if($request->type=="banner")
		{
		$banner = Banner::where('id',$request->id)->first();
		$banner->status = $request->status;
		$this->send_update_notification("banner");
		}
		else if($request->type=="category")
		{
			$banner = Category::where('id',$request->id)->first();
			$banner->status = $request->status;
			$this->send_update_notification("category");
		}
		else if($request->type=="subcategory")
		{
			$banner = Subcategory::where('id',$request->id)->first();
			$banner->status = $request->status;
			$this->send_update_notification("subcategory");
		}
		else if($request->type=="innercategory")
		{
			$banner = Innercategory::where('id',$request->id)->first();
			$banner->status = $request->status;
			$this->send_update_notification("innercategory");
		}
		else if($request->type=="subinnnercategory")
		{
			$banner = Subinnnercategory::where('id',$request->id)->first();
			$banner->status = $request->status;
			$this->send_update_notification("subinnnercategory");
		}
		
		elseif($request->type=="users")
		{
		$banner = User::where('id',$request->id)->first();
		$banner->status = $request->status;	
		$title="Delete";
		$description="Your account is inactive by admin.Please Contact to admin";
		$type="delete";
		$this->notification($banner->firebase_token, $title,$description,$type);
		}
		if($banner->save())
		{
			 
			 // session()->put('success','Status change successfully');
			$data['status'] = 1;
			return response()->json($data);
		}
		else{
			session()->put('warning','Status not change successfully');
			$data['status'] = 0;
			return response()->json($data);
		}
	}
	public function get_user($id)
	{
		return User::where('id',$id)->first();
	}
	public function user_history(Request $request,$id)
	{
		$user =  $this->get_user($id);
		$lotterys = AddLotteryTicket::select("add_lottery_tickets.*",DB::raw("winners.winning_category"),DB::raw("winners.winning_price"))
							->leftjoin("winners",function($join){
							   $join->on("winners.id","=","add_lottery_tickets.win_id");
						     })
						 ->where(['add_lottery_tickets.is_deleted'=>0,'add_lottery_tickets.user_id'=>$id,'add_lottery_tickets.status'=>1])
						 ->orderBy('add_lottery_tickets.id','desc')->get();
						 // echo "<pre>";
						 // print_r($lotterys);exit;
		return view ('users.user-history',compact('lotterys','user'));
	}
	public function agent_history(Request $request,$id)
	{
		$user =  $this->get_user($id);
		$codes = DB::table("codes")->select("*",DB::raw("sum(`value`) as total_value"),DB::raw("count(`code`) as total_code"))
					->where(['is_deleted'=>0,'user_id'=>$id])
					->groupBy('today_date')->get();
		
		
		return view ('users.agent-history',compact('codes','user'));
	}
	public function agent_code_listing(Request $request,$date,$id)
	{
		$user =  $this->get_user($id);
		$vouchers = Voucher::where(['is_deleted'=>0])->get();
		if($request->query())
		{
			$status_code = $request->status ?? "";
			$amount = $request->amount ?? "";
			$plan = $request->plan ?? "";
			$query='';
			
			
			
			
			
			$codes = DB::table("codes")->select("codes.*",DB::raw("vs.name as voucher_name"))
						->leftjoin("vouchers as vs",function($join){
							$join->on("vs.id","=","codes.voucher_id");
						})
						->where(['codes.is_deleted'=>0,'codes.user_id'=>$id,'codes.today_date'=>$date]);	
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
					$codes =	$codes->get();
						
						
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
						->where(['codes.is_deleted'=>0,'codes.user_id'=>$id,'codes.today_date'=>$date])
						->get();
		}
		// echo "<pre>";
		// print_r($codes);
		// exit;
		return view ('users.agent-code-listing',compact('codes','user','vouchers','status_code','amount','plan'));
	}
	public function check_code_cond()
	{
		return 1;
	}	
	public function match_code()
	{
		
		$lotterys_count = Lottery::where(['is_deleted'=>0,'status'=>1])->count();
		
		if($lotterys_count > 0)
		{
		
			$lotterys = Lottery::where(['is_deleted'=>0,'status'=>1])->orderBy('id','desc')->get();
			
			$result_array = array();
					$result_power_ball_array = array();
					$result_final = array();
					$result_final_powerball = array();
					$final_a = array();
					$resultant_array = array();
					// dd($lottery_main); die;
			foreach($lotterys as $lottery_main)	
			{
			 
				$random_code = $this->generateCode(6);
			
				$powerball    = $this->generateCodePowerball(1);
				
			
				// $random_array = array(10,20,30,40,50,11);
				$random_array = $this->generateCode(6);
		
				$lotterys_ticket_count = AddLotteryTicket::where(['is_deleted'=>0,'lottery_status'=>0,'status'=>1,'lottery_id'=>$lottery_main->id])->count();
				
				if($lotterys_ticket_count > 0)
				{
			
					$lotterys_ticket = AddLotteryTicket::where(['is_deleted'=>0,'lottery_status'=>0,'status'=>1,'lottery_id'=>$lottery_main->id])->get();
					$lotterys_ticket_ids = AddLotteryTicket::where(['is_deleted'=>0,'lottery_status'=>0,'status'=>1,'lottery_id'=>$lottery_main->id])->pluck('id')->toArray();
					$i=0;
					foreach($lotterys_ticket as $lottery)
					{
						$lottery_no_array = explode(",",$lottery->lottery_no);
						$j=0;
						
						$result=array_diff($lottery_no_array,$random_array);
						
						
						$resultant_array[$lottery->id][] = 6 -  count($result);

						$array[$lottery->id] = $lottery_no_array;
						
						if($powerball==$lottery->power_ball_no)
						{
							$result_power_ball_array[$lottery->id] = $lottery->power_ball_no;
						}
						else
						{
							$result_power_ball_array[$lottery->id] = 0;
						}
						
						$i++;
						
					}
					
					$category1 = $lottery_main->cat1_max_winner;
					$category2 = $lottery_main->cat2_max_winner;
					$category3 = $lottery_main->cat3_max_winner;
					$category4 = $lottery_main->cat4_max_winner;
					$category5 = $lottery_main->cat5_max_winner;
					$category6 = $lottery_main->cat6_max_winner;
					$category7 = $lottery_main->cat7_max_winner;
					$category8 = $lottery_main->cat8_max_winner;
					$category_array = [
											"6 + power ball"=>$category1,
											"6"=>$category2,
											"5 + power ball"=>$category3,
											"5"=>$category4,
											"4 + power ball"=>$category5,
											"4"=>$category6,
											"3 + power ball"=>$category7,
											"3"=>$category8,
											];
											// echo "2"; exit;
					if($resultant_array)
					{						
					foreach($resultant_array as $key1=>$val)
					{
						
							if($val[0]==6)
							{
								$result_final[$key1] = $val[0];
							}
							else if($val[0]==5)
							{
								$result_final[$key1] = $val[0];
							}
							else if($val[0]==4)
							{
								$result_final[$key1] = $val[0];
							}
							else if($val[0]==3)
							{
								$result_final[$key1] = $val[0];
							}
							
							if($val[0]==6 && $result_power_ball_array[$key1] > 0)
							{
								$result_final_powerball[$key1] = $val[0];
							}
							else if($val[0]==5 && $result_power_ball_array[$key1] > 0)
							{
								$result_final_powerball[$key1] = $val[0];
							}
							
							else if($val[0]==5 && $result_power_ball_array[$key1] > 0)
							{
								$result_final_powerball[$key1] = $val[0];
							}
							
							else if($val[0]==5 && $result_power_ball_array[$key1] > 0)
							{
								$result_final_powerball[$key1] = $val[0];
							}
						
					}
					}
					
					 if($result_final)
					{
				
						$k=0;
						foreach($result_final as $key_val=>$value)
						{
							if(count($result_final_powerball)  > 0 && array_key_exists($key_val,$result_final_powerball))
							{
								$final_a[$key_val] =  $value." + power ball";
								
							}
							else
							{
								$final_a[$key_val] =  $value;
								
							}
							$k++;
						}
					}
					
					 $vals = array_count_values($final_a);
					foreach($category_array as $cat_key=>$cat_val)
					{
						if(array_key_exists($cat_key,$vals))
						{
							
							if($vals[$cat_key] > $cat_val)
							{
								
								$check_code_cond = $this->check_code_cond();
							
							}
						}
						
					}
					
					if($lotterys_ticket_ids)
					{
					
						foreach($lotterys_ticket_ids as $value_final)
						{
					
							$lottery_ticket_info = $this->get_lottery_ticket($value_final);
							if($final_a && array_key_exists($value_final,$final_a))
							{
									
								$win_id = $this->add_winner($lottery_ticket_info,$final_a[$value_final],$random_array,$powerball);
								$this->update_lottery_ticket($value_final,1,$win_id,$random_array,$powerball);
								$this->winner_number($random_array,$powerball);
								
							}
							else
							{
								$this->winner_number($random_array,$powerball);
								$this->update_lottery_ticket($value_final,2,0,$random_array,$powerball);
							}
						}
					} 
					
					
				}
				
				
			}
		}
		return back()->with("message",'Lottery Draw Generated Successfully');
	}
	public function cron_job(Request $request)
	{
		
		$lotterys_count = Lottery::where(['is_deleted'=>0,'status'=>1])->count();
		if($lotterys_count > 0)
		{
		 
			$lotterys = Lottery::where(['is_deleted'=>0,'status'=>1])->orderBy('id','desc')->get();
			$result_array = array();
					$result_power_ball_array = array();
					$result_final = array();
					$result_final_powerball = array();
					$final_a = array();
					$resultant_array = array();
			foreach($lotterys as $lottery_main)	
			{
			//$random_code = $this->generateCode(6);
			
				$powerball    = $this->generateCodePowerball(1);
				$random_array = $this->generateCode(6);
			
		
				$lotterys_ticket_count = AddLotteryTicket::where(['is_deleted'=>0,'lottery_status'=>0,'status'=>1,'lottery_id'=>$lottery_main->id])->count();
				
				if($lotterys_ticket_count > 0)
				{
					$lotterys_ticket = AddLotteryTicket::where(['is_deleted'=>0,'lottery_status'=>0,'status'=>1,'lottery_id'=>$lottery_main->id])->get();
					$lotterys_ticket_ids = AddLotteryTicket::where(['is_deleted'=>0,'lottery_status'=>0,'status'=>1,'lottery_id'=>$lottery_main->id])->pluck('id')->toArray();
					$i=0;
					
					foreach($lotterys_ticket as $lottery)
					{
						$lottery_no_array = explode(",",$lottery->lottery_no);
						$j=0;
						
						$result=array_diff($lottery_no_array,$random_array);
						
						
						$resultant_array[$lottery->id][] = 6 -  count($result);

						$array[$lottery->id] = $lottery_no_array;
						
						if($powerball==$lottery->power_ball_no)
						{
							$result_power_ball_array[$lottery->id] = $lottery->power_ball_no;
						}
						else
						{
							$result_power_ball_array[$lottery->id] = 0;
						}
						
						$i++;
						
					}
					
					$category1 = $lottery_main->cat1_max_winner;
					$category2 = $lottery_main->cat2_max_winner;
					$category3 = $lottery_main->cat3_max_winner;
					$category4 = $lottery_main->cat4_max_winner;
					$category5 = $lottery_main->cat5_max_winner;
					$category6 = $lottery_main->cat6_max_winner;
					$category7 = $lottery_main->cat7_max_winner;
					$category8 = $lottery_main->cat8_max_winner;
					$category_array = [
											"6 + power ball"=>$category1,
											"6"=>$category2,
											"5 + power ball"=>$category3,
											"5"=>$category4,
											"4 + power ball"=>$category5,
											"4"=>$category6,
											"3 + power ball"=>$category7,
											"3"=>$category8,
											];
					if($resultant_array)
					{						
					foreach($resultant_array as $key1=>$val)
					{
						
							if($val[0]==6)
							{
								$result_final[$key1] = $val[0];
							}
							else if($val[0]==5)
							{
								$result_final[$key1] = $val[0];
							}
							else if($val[0]==4)
							{
								$result_final[$key1] = $val[0];
							}
							else if($val[0]==3)
							{
								$result_final[$key1] = $val[0];
							}
							
							if($val[0]==6 && $result_power_ball_array[$key1] > 0)
							{
								$result_final_powerball[$key1] = $val[0];
							}
							else if($val[0]==5 && $result_power_ball_array[$key1] > 0)
							{
								$result_final_powerball[$key1] = $val[0];
							}
							
							else if($val[0]==5 && $result_power_ball_array[$key1] > 0)
							{
								$result_final_powerball[$key1] = $val[0];
							}
							
							else if($val[0]==5 && $result_power_ball_array[$key1] > 0)
							{
								$result_final_powerball[$key1] = $val[0];
							}
						
					}
					}
					
					 if($result_final)
					{
						$k=0;
						foreach($result_final as $key_val=>$value)
						{
							if(count($result_final_powerball)  > 0 && array_key_exists($key_val,$result_final_powerball))
							{
								$final_a[$key_val] =  $value." + power ball";
								
							}
							else
							{
								$final_a[$key_val] =  $value;
								
							}
							$k++;
						}
					}
					
					 $vals = array_count_values($final_a);
					foreach($category_array as $cat_key=>$cat_val)
					{
						if(array_key_exists($cat_key,$vals))
						{
							
							if($vals[$cat_key] > $cat_val)
							{
								
								$check_code_cond = $this->check_code_cond();
							
							}
						}
						
					}
					
					if($lotterys_ticket_ids)
					{
					
						foreach($lotterys_ticket_ids as $value_final)
						{
					
							$lottery_ticket_info = $this->get_lottery_ticket($value_final);
							if($final_a && array_key_exists($value_final,$final_a))
							{
									// echo "5"; exit;
								$win_id = $this->add_winner($lottery_ticket_info,$final_a[$value_final],$random_array,$powerball);
								$this->update_lottery_ticket($value_final,1,$win_id,$random_array,$powerball);
								$this->winner_number($random_array,$powerball);
							}
							else
							{
								
								$this->update_lottery_ticket($value_final,2,0,$random_array,$powerball);
								$this->winner_number($random_array,$powerball);
							}
						}
					} 
					
					
				}
				
				
			}
		}
		echo "Lottery";
	}
	
	private function get_lottery_ticket($id)
	{
	   // echo $id; exit;
		return AddLotteryTicket::find($id);
	}
	private function update_lottery_ticket($id,$status,$win_id,$random_array,$powerball)
	{
	
		$add_lottery_ticket = AddLotteryTicket::find($id);
		$add_lottery_ticket->lottery_status = $status;
		$add_lottery_ticket->win_id = $win_id;
		$add_lottery_ticket->lottery_draw_no = implode(",",$random_array);
		$add_lottery_ticket->lottery_draw_power_ball = $powerball;
		$add_lottery_ticket->draw_date = date("Y-m-d");
		$add_lottery_ticket->save();
	}
	private function winner_number($random_array,$powerball)
	{
		$wining = New WinningNumber;
	    $wining->winning_number = implode(",",$random_array);
	    $wining->power_boll = $powerball;
	    $wining->winning_number_date = date('Y-m-d');
	    $wining->save();
	}
	
	private function add_winner($lottery_ticket_info,$winning_category,$random_array,$powerball)
	{ 
	
		$winner = new Winner;
		$winner->user_id = $lottery_ticket_info->user_id;
		$winner->lottery_id = $lottery_ticket_info->lottery_id;
		$winner->add_lottery_id = $lottery_ticket_info->id;
		$winner->lottery_draw_no = implode(",",$random_array);
		$winner->lottery_draw_power_ball = $powerball;
		$winner->winning_price = $this->get_lottery_category_value($lottery_ticket_info->lottery_id,$winning_category);
		$winner->winning_category = $winning_category;
		$winner->today_date = date("Y-m-d");
		$winner->save();
		$winner_cat = $this->get_lottery_category($winning_category);
		
		$winning_price = $this->get_lottery_category_value($lottery_ticket_info->lottery_id,$winning_category);
		if(is_numeric($winning_price))
		{
			$order_id  = "ORDER00".(rand(1000000,9999999999))."U".Auth::user()->id;;
			$this->transaction_save_credit($order_id,$winning_price,$winner->id,$lottery_ticket_info->user_id);
		}			
		$user = $this->get_user($lottery_ticket_info->user_id);
		$subject = "You won";
		$lottery= $this->get_lottery($lottery_ticket_info->lottery_id);
		$draw_array = $this->get_lottery_next_draw_date_and_time($lottery->id);
		$draw_day  = $draw_array["day"];
		$draw_date = date("d M Y",strtotime($draw_day));
		$draw_date_time = date("Y-m-d h:i:s",strtotime("$draw_day $lottery->draw_timing"));	
		if($winner_cat=='cat8_val')
		{
			
			
			$this->add_user_free_ticket($lottery_ticket_info->user_id,$lottery_ticket_info->lottery_id,$winner->id,$draw_date,$draw_date_time,$lottery_ticket_info->id);
			
			
			$url = "http://bewin.one/".$lottery->id;
			$message = 'Congratulations. <br><br>

			You have won <b>“Free Play”</b> in bewin.one drawing date <b>"'.$draw_date.'"</b> <br><br>
			<a href="'.$url.'" class="btn btn-success" style="color:#fff;background-color:#dd4b39;border-color:#d73925;display:inline-block;margin-bottom:0;font-weight:400;text-align:center;white-space:nowrap;vertical-align:middle;background-image:none;border:1px solid transparent;padding:6px 12px;font-size:14px;line-height:1.42857143;border-radius:4px;overflow:visible;text-transform:none">Free Play</a><br><br>
			Thank you for choosing bewin.one <br><br>
			';
		    $this->send_order_mail($user->email,$message,$user->first_name,$subject);
		    $this->send_order_mail("trilok@peninftech.com",$message,$user->first_name,$subject);
		}
		else
		{
			$message = 'Congratulations. <br><br>

			You have won <b>“'.$winner->winning_price.'”</b> in bewin.one drawing date <b>"'.$draw_date.'"</b>. <br><br>
			
			Thank you for choosing bewin.one <br><br>
			';
		    $this->send_order_mail($user->email,$message,$user->first_name,$subject);
			$this->send_order_mail("trilok@peninftech.com",$message,$user->first_name,$subject);
		}
		return $winner->id;
	}
	
	public function send_order_mail($email,$msg,$name,$subject)
	{
		Mail::to($email)
		->send(new Usermail($msg,$name,$subject));
	}
	private function get_lottery_category_value($id,$category)
	{
		$category_array = [
							"6 + power ball"	=> "cat1_val",
							"6"					=> "cat2_val",
							"5 + power ball"	=> "cat3_val",
							"5"					=> "cat4_val",
							"4 + power ball"	=> "cat5_val",
							"4"					=> "cat6_val",
							"3 + power ball"	=> "cat7_val",
							"3"					=> "cat8_val",
											];
		if(array_key_exists($category,$category_array))
		{
			$val = $category_array[$category];
		}
		$lottery = Lottery::where(['id'=>$id])->first();
		if($lottery)
			return $lottery->$val;
		else
			return 0;
	}
	private function get_lottery_category($category)
	{
		$category_array = [
							"6 + power ball"	=> "cat1_val",
							"6"					=> "cat2_val",
							"5 + power ball"	=> "cat3_val",
							"5"					=> "cat4_val",
							"4 + power ball"	=> "cat5_val",
							"4"					=> "cat6_val",
							"3 + power ball"	=> "cat7_val",
							"3"					=> "cat8_val",
											];
		if(array_key_exists($category,$category_array))
		{
			$val = $category_array[$category];
			return $val;
		}
		else
		{
			return 0;
		}
		
			
	}
	private function generateCode($limit)
	{
		
		$a=array("01"=>"01","02"=>"02","03"=>"03","04"=>"04","05"=>"05","06"=>"06","07"=>"07","08"=>"08","09"=>"09","10"=>"10","11"=>"11","12"=>"12","13"=>"13","14"=>"14","15"=>"15","16"=>"16","17"=>"17","18"=>"18","19"=>"19","20"=>"20","21"=>"21","22"=>"22","23"=>"23","24"=>"24","25"=>"25","26"=>"26","27"=>"27","28"=>"28","29"=>"29","30"=>"30","31"=>"31","32"=>"32","33"=>"33","34"=>"34","35"=>"35","36"=>"36","37"=>"37","38"=>"38","39"=>"39","40"=>"40","41"=>"41","42"=>"42","43"=>"43","44"=>"44","45"=>"45","46"=>"46","47"=>"47","48"=>"48","49"=>"49","50"=>"50");
       return $random_array = (array_rand($a,6));

	}
	private function generateCodePowerball($limit)
	{
		
		$a=array("01"=>"01","02"=>"02","03"=>"03","04"=>"04","05"=>"05","06"=>"06","07"=>"07","08"=>"08","09"=>"09","10"=>"10","11"=>"11","12"=>"12","13"=>"13","14"=>"14","15"=>"15","16"=>"16","17"=>"17","18"=>"18","19"=>"19","20"=>"20","21"=>"21","22"=>"22","23"=>"23","24"=>"24","25"=>"25");
       return $random_array = (array_rand($a,1));
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
	public function get_lottery($id)
	{
		return $lottery = Lottery::select('lotteries.*',DB::raw("time_slots.name as draw_timing"),DB::raw("(select ts.name  from time_slots as ts where ts.id=lotteries.end_lottery_time) as end_time"))
		->leftjoin("time_slots",function($join){
			$join->on("time_slots.id","=","lotteries.draw_timing");
		})
		->where(['lotteries.is_deleted'=>0,'lotteries.id'=>$id])
		->first();
		
	}
	private function add_user_free_ticket($user_id,$lottery_id,$winner_id,$draw_date,$draw_date_time,$add_lottery_ticket)
	{
		$user_free_ticket = new UserFreeTicket;
		$user_free_ticket->user_id = $user_id;
		$user_free_ticket->lottery_id = $lottery_id;
		$user_free_ticket->winner_id = $winner_id;
		$user_free_ticket->today_date = date("Y-m-d");
		$user_free_ticket->draw_date = date("Y-m-d",strtotime($draw_date));
		$user_free_ticket->draw_date_time = date("Y-m-d h:i",strtotime($draw_date_time));
		$user_free_ticket->add_lottery_ticket = $add_lottery_ticket;
		$user_free_ticket->status = 0;
		$user_free_ticket->save();
	}	
	public function transaction_save_credit($order_id,$price,$rel_id,$user_id)
	{
		
		$transaction = New Transaction;
		$transaction->user_id = $user_id; 
		$transaction->party_name = Auth::user()->first_name." ".Auth::user()->last_name; 
		$transaction->sales_ledger = Auth::user()->first_name." ".Auth::user()->last_name; 
		$transaction->description = 'Winning Amount'; 
		$transaction->comment = 'Amount Received Via Lottery Ticket Win'; 
		$transaction->lottery_id = 0; 
		$transaction->add_lottery_id = session('add_lottery_id') ?? 0;
		$transaction->form_name ="win";	
		$transaction->order_id = $order_id; 
		$transaction->invoice_number = $order_id; 
		$transaction->transaction_date = date('Y-m-d'); 
		$transaction->today_date = date('Y-m-d'); 
		$transaction->cr = $price ;
		$transaction->rel_id = $rel_id;
		$transaction->p_type = "paid";
		$transaction->save();
		
	}
	//////////////////////////////////////////////////////////////////////////////////////////////////
}
