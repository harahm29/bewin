<?php

namespace App\Http\Controllers;

use App\AddLotteryTicket;
use Illuminate\Http\Request;
use App\Lottery;
use App\User;
use App\Order;
use App\Transaction;
use Auth;
use DB;
use Session;
class AddLotteryTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		
		$lotterys = DB::table("add_lottery_tickets as alt")->select("alt.*",DB::raw("users.first_name as user_name"))
					->where(['alt.is_deleted'=>0])
					->leftjoin("users",function($join){
						$join->on("users.id","=","alt.user_id");
					})
					->orderBy('alt.id','desc')->get();
		return view ('add-lottery-ticket.index',compact('lotterys'));
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
     * @param  \App\AddLotteryTicket  $addLotteryTicket
     * @return \Illuminate\Http\Response
     */
    public function show(AddLotteryTicket $addlotteryticket)
    {
        //
		// echo "<pre>";
		// print_r($addlotteryticket);exit;
		
					$lottery = AddLotteryTicket::select("add_lottery_tickets.*",DB::raw("winners.winning_category"),DB::raw("winners.winning_price"))
							->leftjoin("winners",function($join){
							   $join->on("winners.id","=","add_lottery_tickets.win_id");
						     })
						 ->where(['add_lottery_tickets.is_deleted'=>0,'add_lottery_tickets.id'=>$addlotteryticket->id])
						 ->orderBy('add_lottery_tickets.id','desc')->first();
		// if($lottery->status==1)
			// $status ="<span class='text-success'>Active</span>";
		// else
			// $status ="<span class='text-danger'>InActive</span>";
		
		
	
		if($lottery->lottery_status == 1)
				$status ='<p class="text-success" > '.$lottery->winning_category.'<br>$'.$lottery->winning_price.'</p>';			
		else if($lottery->lottery_status==2)
			$status ='<p class="text-danger" >Looser</p>'; 
		else
			$status ='<p class="text-warning" ><i class="fas fa-clock"></i> Pending</p>';
		$output='';
		$output.= '<table border="0" align="center" class="table"> 
                    <tr>  
                    <td ><label> Lottery Name</label></td>  
                    <td  colspan="2">'.$lottery->lottery_name.'</td>  
                    </tr>
					
					<tr>  
                    <td ><label>Lottery Price</label></td>  
                    <td >'.$lottery->lottery_price.'</td>   
                    </tr>
					 <td ><label>Lottery No & Powerball</label></td>  
                    <td > <span class="text-success">'.$lottery->lottery_draw_no.'<span>,  <span class="text-primary">'.$lottery->lottery_draw_power_ball.'<span<</td>   
                    </tr>
					<tr>  
                    <td ><label>Selected No</label></td>  
                    <td >'.$lottery->lottery_no.'</td>   
                    </tr>
					<tr>  
                   
					<tr>  
                    <td ><label>Power Ball No</label></td>  
                    <td >'.$lottery->power_ball_no.'</td>   
                    </tr>
					<tr>  
                    <td ><label>Date</label></td>  
                    <td >'.date('d-M-Y',strtotime($lottery->today_date)).'</td>   
                    </tr>
					<tr>  
                    <td ><label>Lottery Type</label></td>  
                    <td >'.ucfirst($lottery->lottery_type).'</td>   
                    </tr>
					<tr>  
                    <td ><label>Result</label></td>  
                    <td >'.$status.'</td>   
                    </tr>
					
					
					</table>';  
                    return $output; 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AddLotteryTicket  $addLotteryTicket
     * @return \Illuminate\Http\Response
     */
    public function edit(AddLotteryTicket $addLotteryTicket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AddLotteryTicket  $addLotteryTicket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AddLotteryTicket $addlotteryticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AddLotteryTicket  $addLotteryTicket
     * @return \Illuminate\Http\Response
     */
    public function destroy(AddLotteryTicket $addlotteryticket)
    {
        //
		$addlotteryticket->is_deleted = 1;
		if($addlotteryticket->save())
		{
			return back()->with("message","Lottery Deleted Successfully");
		}
    }
}
