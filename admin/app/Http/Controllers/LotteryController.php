<?php

namespace App\Http\Controllers;

use App\Lottery;
use App\User;
use App\WinningNumber;
use Illuminate\Http\Request;
use Auth;
use Validator;
use DB;
use Session;

class LotteryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		$lotterys = Lottery::where(['is_deleted'=>0])->orderBy('id','desc')->get();
		$weekdays = ["sun","mon","tue","wed","thu","fri","sat"];
		// echo $weekdays[0];exit;
		return view ('lottery.index',compact('lotterys','weekdays'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
		$time_slots = DB::table('time_slots')->where(['is_deleted'=>0])->get();
		$weekdays = DB::table('weekdays')->where(['is_deleted'=>0])->get();
		return view ('lottery.create',compact('time_slots','weekdays'));
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
		// echo "<pre>";
		// print_r($_POST);
		// exit;
		$validator = Validator::make($request->all(), [
				'name' => 'required|max:255',
				'ticket_price' => 'required|max:255',
				'validity' => 'required|max:255',
				'draw_days' => 'required|max:255',
				'draw_timing' => 'required|max:255',
				'start_lottery_time' => 'required|max:255',
				'end_lottery_time' => 'required|max:255',
				'cat1_val' => 'required|max:255',
				'cat1_max_winner' => 'required|max:255',
				'cat2_val' => 'required|max:255',
				'cat2_max_winner' => 'required|max:255',
				'cat3_val' => 'required|max:255',
				'cat3_max_winner' => 'required|max:255',
				'cat4_val' => 'required|max:255',
				'cat4_max_winner' => 'required|max:255',
				'cat5_val' => 'required|max:255',
				'cat5_max_winner' => 'required|max:255',
				'cat6_val' => 'required|max:255',
				'cat6_max_winner' => 'required|max:255',
				'cat7_val' => 'required|max:255',
				'cat7_max_winner' => 'required|max:255',
				'cat8_val' => 'required|max:255',
				'cat8_max_winner' => 'required|max:255',
				
		]);
		
		
          if ($validator->fails()) 
		  {
           return back()
               ->withInput()
               ->withErrors($validator);
		  }
			if($request->hasFile('image') && $request->image->isValid())
           {
                $extension = $request->image->extension();
				$fileName  = time().".$extension";
				$request->image->move(public_path('images'),$fileName);
           } else{
				$fileName  ='default.jpg';
		   }
		   
		   
         $lottery = new Lottery;
         $lottery->user_id  			= Auth::user()->id;
		 $lottery->name  				= ucwords($request->name);
		 $lottery->ticket_price  		= $request->ticket_price ?? 0;
		 $lottery->draw_days  			= implode(",",$request->draw_days);
		 $lottery->draw_timing  		= $request->draw_timing ?? 0;
		 $lottery->start_lottery_time  	= $request->start_lottery_time ?? 0;
		 $lottery->end_lottery_time  	= $request->end_lottery_time ?? 0;
		 $lottery->validity  			= date("Y-m-d",strtotime($request->validity)) ?? "";
		 $lottery->image  				= $fileName;
		 $lottery->cat1_val  			= $request->cat1_val ?? "";
		 $lottery->cat1_max_winner  	= $request->cat1_max_winner ?? "";
		 $lottery->cat2_val  			= $request->cat2_val ?? "";
		 $lottery->cat2_max_winner  	= $request->cat2_max_winner ?? "";
		 $lottery->cat3_val  			= $request->cat3_val ?? "";
		 $lottery->cat3_max_winner  	= $request->cat3_max_winner ?? "";
		 $lottery->cat4_val  			= $request->cat4_val ?? "";
		 $lottery->cat4_max_winner  	= $request->cat4_max_winner ?? "";
		 $lottery->cat5_val  			= $request->cat5_val ?? "";
		 $lottery->cat5_max_winner  	= $request->cat5_max_winner ?? "";
		 $lottery->cat6_val  			= $request->cat6_val ?? "";
		 $lottery->cat6_max_winner  	= $request->cat6_max_winner ?? "";
		 $lottery->cat7_val  			= $request->cat7_val ?? "";
		 $lottery->cat7_max_winner  	= $request->cat7_max_winner ?? "";
		 $lottery->cat8_val  			= $request->cat8_val ?? "";
		 $lottery->cat8_max_winner  	= $request->cat8_max_winner ?? "";
	    
		if( $lottery->save())
		{
			return redirect('lottery')->with('message','Lottery Added Successfully.');
		}
	
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Lottery  $lottery
     * @return \Illuminate\Http\Response
     */
	 private function get_time_slot($id)
	 {
		 return $time_slot = DB::table("time_slots")->where('id',$id)->first();
	 }
    public function show(Lottery $lottery)
    {
        //
		$generate_url = url('/public/images/'.$lottery->image);
		$draw_timing = $this->get_time_slot($lottery->draw_timing)->name ?? "";
		$start_lottery_time = $this->get_time_slot($lottery->start_lottery_time)->name ?? "";
		$end_lottery_time = $this->get_time_slot($lottery->end_lottery_time)->name ?? "";
		$output='';
		$output.= '<table border="0" align="center" class="table"> 
                    <tr>  
                    <td ><label> Lottery Name</label></td>  
                    <td  colspan="2">'.$lottery->name.'</td>  
                    </tr>
					<tr>  
                    <td ><label>Banner/Image</label></td>  
                    <td colspan="2"><a href="'.$generate_url.'" ><img src="'.$generate_url.'" width="50" /></a></td>  
                    </tr>
					<tr>  
                    <td ><label>Draw Days</label></td>  
                    <td colspan="2">'.ucwords($lottery->draw_days).'</td>  
                    </tr>
					<tr>  
                    <td ><label>Draw Timing</label></td>  
                    <td colspan="2">'.$draw_timing.'</td>  
                    </tr>
					<tr>  
                    <td ><label>Start Lottery Time</label></td>  
                    <td colspan="2">'.$start_lottery_time.'</td>  
                    </tr>
					<tr>  
                    <td ><label>End Lottery Time</label></td>  
                    <td colspan="2">'.$end_lottery_time.'</td>  
                    </tr>
					<tr>  
                    <td ><label>Validity</label></td>  
                    <td colspan="2">'.date("d-M-Y",strtotime($lottery->validity)).'</td>  
                    </tr>
					
					<tr>  
                    <td ><label>Ticket Price</label></td>  
                    <td colspan="2">'.$lottery->ticket_price.'</td>  
                    </tr>
					<tr>  
                    <td ><label>6+power ball</label></td>  
                    <td >'.$lottery->cat1_val.'</td>  
                    <td >'.$lottery->cat1_max_winner.'</td>  
                    </tr>
					<tr>  
                    <td ><label>6 of 6</label></td>  
                    <td >'.$lottery->cat2_val.'</td>  
                    <td >'.$lottery->cat2_max_winner.'</td>  
                    </tr>
					<tr>  
                    <td ><label>5+power ball</label></td>  
                    <td >'.$lottery->cat3_val.'</td>  
                    <td >'.$lottery->cat3_max_winner.'</td>  
                    </tr>
					<tr>  
                    <td ><label>5 of 6</label></td>  
                    <td >'.$lottery->cat4_val.'</td>  
                    <td >'.$lottery->cat4_max_winner.'</td>  
                    </tr>
					<tr>  
                    <td ><label>4+power ball</label></td>  
                    <td >'.$lottery->cat5_val.'</td>  
                    <td >'.$lottery->cat5_max_winner.'</td>  
                    </tr>
					<tr>  
                    <td ><label>4 of 6</label></td>  
                    <td >'.$lottery->cat6_val.'</td>  
                    <td >'.$lottery->cat6_max_winner.'</td>  
                    </tr>
					<tr>  
                    <td ><label>3+power ball</label></td>  
                    <td >'.$lottery->cat7_val.'</td>  
                    <td >'.$lottery->cat7_max_winner.'</td>  
                    </tr>
					<tr>  
                    <td ><label>3 of 6</label></td>  
                    <td >'.$lottery->cat8_val.'</td>  
                    <td >'.$lottery->cat8_max_winner.'</td>  
                    </tr>
					
					</table>';  
                    return $output; 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lottery  $lottery
     * @return \Illuminate\Http\Response
     */
    public function edit(Lottery $lottery)
    {
        //
		$time_slots = DB::table('time_slots')->where(['is_deleted'=>0])->get();
		$draw_day_array = explode(",",$lottery->draw_days);
		$weekdays = DB::table('weekdays')->where(['is_deleted'=>0])->get();
		// echo "<pre>";
		// print_r($draw_day_array);
		// exit;
		return view ('lottery.edit',compact('lottery','time_slots','draw_day_array','weekdays'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lottery  $lottery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lottery $lottery)
    {
       
		$validator = Validator::make($request->all(), [
				'name' => 'required|max:255',
				'ticket_price' => 'required|max:255',
				'validity' => 'required|max:255',
				'draw_days' => 'required|max:255',
				'draw_timing' => 'required|max:255',
				'start_lottery_time' => 'required|max:255',
				'end_lottery_time' => 'required|max:255',
				'cat1_val' => 'required|max:255',
				'cat1_max_winner' => 'required|max:255',
				'cat2_val' => 'required|max:255',
				'cat2_max_winner' => 'required|max:255',
				'cat3_val' => 'required|max:255',
				'cat3_max_winner' => 'required|max:255',
				'cat4_val' => 'required|max:255',
				'cat4_max_winner' => 'required|max:255',
				'cat5_val' => 'required|max:255',
				'cat5_max_winner' => 'required|max:255',
				'cat6_val' => 'required|max:255',
				'cat6_max_winner' => 'required|max:255',
				'cat7_val' => 'required|max:255',
				'cat7_max_winner' => 'required|max:255',
				'cat8_val' => 'required|max:255',
				'cat8_max_winner' => 'required|max:255',
		]);
		
		
          if ($validator->fails()) 
		  {
           return back()
               ->withInput()
               ->withErrors($validator);
		  }
			if($request->hasFile('image') && $request->image->isValid())
           {
                $extension = $request->image->extension();
				$fileName  = time().".$extension";
				$request->image->move(public_path('images'),$fileName);
           } else{
				$fileName  =$lottery->image;
		   }
		 $lottery->status  			= 0;
		 $lottery->expire_date  	= date('Y-m-d');
		 $lottery->save();
		   
         $lottery1 = new Lottery;
         $lottery1->user_id  			= Auth::user()->id;
		 $lottery1->name  				= ucwords($request->name).'-'.date('Y-m-d');
		 $lottery1->ticket_price  		= $request->ticket_price ?? 0;
		 $lottery1->draw_days  			= implode(",",$request->draw_days);
		 $lottery1->draw_timing  		= $request->draw_timing ?? 0;
		 $lottery1->start_lottery_time  	= $request->start_lottery_time ?? 0;
		 $lottery1->end_lottery_time  	= $request->end_lottery_time ?? 0;
		 $lottery1->validity  			= date("Y-m-d",strtotime($request->validity)) ?? "";
		 $lottery1->image  				= $fileName;
		 $lottery1->cat1_val  			= $request->cat1_val ?? "";
		 $lottery1->cat1_max_winner  	= $request->cat1_max_winner ?? "";
		 $lottery1->cat2_val  			= $request->cat2_val ?? "";
		 $lottery1->cat2_max_winner  	= $request->cat2_max_winner ?? "";
		 $lottery1->cat3_val  			= $request->cat3_val ?? "";
		 $lottery1->cat3_max_winner  	= $request->cat3_max_winner ?? "";
		 $lottery1->cat4_val  			= $request->cat4_val ?? "";
		 $lottery1->cat4_max_winner  	= $request->cat4_max_winner ?? "";
		 $lottery1->cat5_val  			= $request->cat5_val ?? "";
		 $lottery1->cat5_max_winner  	= $request->cat5_max_winner ?? "";
		 $lottery1->cat6_val  			= $request->cat6_val ?? "";
		 $lottery1->cat6_max_winner  	= $request->cat6_max_winner ?? "";
		 $lottery1->cat7_val  			= $request->cat7_val ?? "";
		 $lottery1->cat7_max_winner  	= $request->cat7_max_winner ?? "";
		 $lottery1->cat8_val  			= $request->cat8_val ?? "";
		 $lottery1->cat8_max_winner  	= $request->cat8_max_winner ?? "";
	    
		if($lottery1->save())
		{
			return redirect('lottery')->with('message','Lottery Updated Successfully.');
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lottery  $lottery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lottery $lottery)
    {
        //
		$lottery->is_deleted  	= 1;
		if($lottery->save())
		{
			return back()->with('Lottery Deleted Successfully.');
		}
    }
///////////////////COUNT LOTTERY TICKET   AddLotteryTicket
public function count_lottery_ticket(Request $request)
{
 $total_ticket = Lottery::select('add_lottery_tickets.*', DB::raw('SUM(add_lottery_tickets.lottery_id) As total_lottery_id'))
         ->leftJoin('add_lottery_tickets', 'add_lottery_tickets.lottery_id', '=', 'lotteries.id')
         ->where('lotteries.is_deleted', 0)
         ->get();
		 echo "<pre>";
		 print_r($total_ticket); exit;
  return view('lottery.total_count_ticket',compact('total_ticket'));		 
}
//////////////////////////SHOW WINNER NAME
public function show_winner_name(Request $request)
{
 $winner_name = User::select('users.first_name','users.last_name','winners.today_date')
         ->Join('winners','winners.user_id', '=', 'users.id')
         ->where('users.is_deleted', 0)
         ->get();
		 
		 
  return view('lottery.show_winner_name',compact('winner_name'));		 
}
//////////////////////////SHOW WINNER NUMBER
public function show_winner_number(Request $request)
{
 $winner_number = WinningNumber::get();
 return view('lottery.show_winner_number',compact('winner_number'));		 
}	
}
