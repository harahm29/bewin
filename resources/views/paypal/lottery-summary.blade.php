@extends('layouts.admin')
@section('title','PayPal')
@section('content')
<style>
 .content {
                margin-top: 200px;
              
                text-align: center;
            }
			
			body{margin-top:20px;
background:#eee;
}

/* WRAPPERS */
#wrapper {
  width: 100%;
  overflow-x: hidden;
}
.wrapper {
  padding: 0 20px;
}
.wrapper-content {
  padding: 20px 10px 40px;
}
#page-wrapper {
  padding: 0 15px;
  min-height: 568px;
  position: relative !important;
}
@media (min-width: 768px) {
  #page-wrapper {
    position: inherit;
    margin: 0 0 0 240px;
    min-height: 2002px;
  }
}

/* Payments */
.payment-card {
  background: #ffffff;
  padding: 20px;
  margin-bottom: 25px;
  border: 1px solid #e7eaec;
}
.payment-icon-big {
  font-size: 60px;
  color: #d1dade;
}
.payments-method.panel-group .panel + .panel {
  margin-top: -1px;
}
.payments-method .panel-heading {
  padding: 15px;
}
.payments-method .panel {
  border-radius: 0;
}
.payments-method .panel-heading h5 {
  margin-bottom: 5px;
}
.payments-method .panel-heading i {
  font-size: 26px;
}

.payment-icon-big {
    font-size: 60px !important;
    color: #d1dade;
}

.form-control,
.single-line {
  background-color: #FFFFFF;
  background-image: none;
  border: 1px solid #e5e6e7;
  border-radius: 1px;
  color: inherit;
  display: block;
  padding: 6px 12px;
  transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
  width: 100%;
  font-size: 14px;
}
.text-navy {
    color: #1ab394;
}
.text-success {
    color: #1c84c6;
}
.text-warning {
    color: #f8ac59;
}
.ibox {
  clear: both;
  margin-bottom: 25px;
  margin-top: 0;
  padding: 0;
}
.ibox.collapsed .ibox-content {
  display: none;
}
.ibox.collapsed .fa.fa-chevron-up:before {
  content: "\f078";
}
.ibox.collapsed .fa.fa-chevron-down:before {
  content: "\f077";
}
.ibox:after,
.ibox:before {
  display: table;
}
.ibox-title {
  -moz-border-bottom-colors: none;
  -moz-border-left-colors: none;
  -moz-border-right-colors: none;
  -moz-border-top-colors: none;
  background-color: #ffffff;
  border-color: #e7eaec;
  border-image: none;
  border-style: solid solid none;
  border-width: 3px 0 0;
  color: inherit;
  margin-bottom: 0;
  padding: 14px 15px 7px;
  min-height: 48px;
}
.ibox-content {
  background-color: #ffffff;
  color: inherit;
  padding: 15px 20px 20px 20px;
  border-color: #e7eaec;
  border-image: none;
  border-style: solid solid none;
  border-width: 1px 0;
}
.ibox-footer {
  color: inherit;
  border-top: 1px solid #e7eaec;
  font-size: 90%;
  background: #ffffff;
  padding: 10px 15px;
}
.text-danger {
    color: #ed5565;
}
.ticket-price
{
	background: #e62e7c;color: #fff;color: #fff;
    font-weight: 600;
    font-size: 18px;
    padding: 2px 15px;
    line-height: 26px;
    border-radius: 0px 3px 3px 0px;
}
.self-number li a 
{
	display: block;
    color: #fff;
    background: #1FC157;
    border: 1px solid #1FC157;
    border-radius: 50%;
    font-size: 13px;
    font-weight: 700;
    width: 30px;
    height: 30px;
    text-align: center;
    line-height: 30px;
    margin: 0px 1px;
	display: inline-block;
}
</style>
					@php 
					function get_lottery($lottery_days,$start_time,$end_time)
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
					@endphp
@php 
if(session('lottery_id'))
{
	if(session('total_price') > $wallet)
	{
		session(['lottery_back_url'=>'lottery-summary/'.$lottery->id]);
	}
	else
	{
		session(['lottery_back_url'=>'my-banking']);
	}
}
else
{
	return redirect('/');
}

								
								$draw_days_array = explode(",",$lottery->draw_days);
								$current_time = date("h a");
								$timeSlotStart = DB::table("time_slots")->where(['id'=>$lottery->start_lottery_time])->first();
								$start_time = $timeSlotStart->name;
								$timeSlot = DB::table("time_slots")->where(['id'=>$lottery->end_lottery_time])->first();
								$end_time = $timeSlot->name;
								 $lottery_date = get_lottery($draw_days_array,$start_time,$end_time);
									
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
									
									
	 $draw_datet = date("Y-m-d h:i:s",strtotime("$lottery_date $lottery->draw_timing"));
	 $draw_date = date("Y-m-d",strtotime($lottery_date));
	 $draw_time = $lottery->draw_timing;
	$free_play = get_user_free_ticket($lottery->id,$draw_date,$draw_datet);
	function get_user_free_ticket($lottery_id,$draw_date,$draw_time)
	{
		if(Auth::check())
			$user_id = Auth::user()->id;
		else
			$user_id = 0;
		$draw_date_time = $draw_time;
		$free_ticket_count = DB::table('user_free_tickets')
							->where(['user_id'=>$user_id,
									  'draw_date'=>$draw_date,
									  'lottery_id'=>$lottery_id,
									  'status'=>0
									  ])
							->where('draw_date_time','=',$draw_date_time)
									  ->count();
		if($free_ticket_count > 0)
			return 1;
		else
			return 0;
	}
	
								@endphp

 <!-- Start Bottom Header -->
 <div class="page-area">
            <div class="breadcumb-overlay"></div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="breadcrumb text-center">
                            <div class="section-headline text-center">
                                <h3>Lottery Summary</h3>
                            </div>
                            <ul>
                                <li class="home-bread">Home</li>
                                <li>Lottery Summary</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Header -->
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<br>
				
<div class="container">
<div class="wrapper wrapper-content animated fadeInRight">
   
    <div class="row">
				@if(session("message"))
					<p class="alert alert-success">{{session('message')}}</p>
				@endif
				@if(session("error_message"))
					<p class="alert alert-danger">{{session('error_message')}}</p>
				@endif
        <div class="col-lg-12">

            <div class="ibox">
                <div class="ibox-title">
                   
					<div class="box-header" align="right"> <span align="left" style="float:left;"></span>
									<a  align="right" href="{{url('lottery/'.$lottery->id)}}" class="btn btn-primary btn-sm" data-toggle="tooltip" title=" Lottery" ><b><i class="fas fa-backspace" aria-hidden="true"></i> Back</b></a>

									</div> 
                </div>
				
				<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="section-headline ">
							<h3>{{$lottery->name}}</h3>
							
						</div>
					</div>
                <div class="ibox-content">
					<form action="{{url('paypal')}}" method="post" >
					@csrf
                    <div class="panel-group payments-method" id="accordion">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                
                            </div>
                            <div id="collapseOne" class="">
                                <div class="panel-body">
									@php 
									// echo "<pre>"; 
									// print_r($data_post); 
									 //exit;
									@endphp
                                    <div class="row">
                                        <div class="col-md-10">
										<table   class="table"> 
										<tr>  
										<td ><label>Winning Prize</label></td>  
										<td >${{$lottery->cat1_val}}</td>  
										</tr>
										<tr>  
										<td ><label>Next Draw Date</label></td>  
										<td >{{$lottery_date}} {{$lottery->draw_timing}}</td>  
										</tr>
										<tr>  
										<td ><label>Lottery Price</label></td>  
										<td ><span class="ticket-price" >{{$lottery->ticket_price}}CD<input type="hidden"   name="amount" id="amount" value="{{$lottery->ticket_price}}" /></span></td>  
										</tr>
										<tr>  
										<td ><label>No. of Ticket Want To Purchase</label></td>  
										<td >{{session('ticket_no')}}<input type="hidden" min="1" max="99" class="form-control numeric_feild ticket_no" name="ticket_no" id="ticket_no" value="{{session('ticket_no')}}" /></td>  
										</tr>
										<tr>  
										<td ><label>Selected Numbers </label></td>  
										<td >@if(session('ticket_no') ==1)
											@php $lottery_array = explode(",",session('lottery_select_val')); @endphp
                                               <ul class="self-number">
											   @foreach($lottery_array as $lottery_ball)
                                                    <li><a href="#">{{$lottery_ball}}</a></li>
											   @endforeach
											    <li><a href="#" style="background:blue;">{{session('lottery_select_val_power_ball')}}</a></li>
                                               </ul>
											   @else
												   <span class="text-danger"><b>Please Check Your Mail For Lottery No. After Payment</b></span>
											   @endif
											   
										</td>  
										</tr>
										<tr>  
										<td ><label>Total Price</label></td>  
										<td >@if($free_play==1) $0 (Free Play) @else ${{session('total_price')}} @endif </td>  
										</tr>
										<tr>  
										<td ><label>Wallet Balance</label></td>  
										<td > ${{$wallet ?? ""}}</td>  
										</tr>
										</table>
										
                                           
											
											<input type="hidden" name="lottery_id" id="lottery_id" value="{{$lottery->id}}" />
											<input type="hidden" name="draw_date_time" id="draw_date_time" value="{{date('d M Y',strtotime('next $day'))}} {{$lottery->draw_timing}}" />
											<input type="hidden" name="ticket_no" id="ticket_no" value="{{session('ticket_no')}}" />
											<input type="hidden" name="total_price" id="total_price" value="{{session('total_price')}}" />
											<input type="hidden" name="lottery_select_val"  value="{{session('lottery_select_val')}}" />
											<input type="hidden" name="lottery_select_val_power_ball" value="{{session('lottery_select_val_power_ball')}}" />
											<input  type="hidden" id="auto-num-{{$lottery->id}}" name="auto-num-{{$lottery->id}}" value="{{session('lottery_type')}}"  >
											<input  type="hidden" id="lottery_summary" name="lottery_summary" value="1"  >
											
											@if(session('total_price') > $wallet && $free_play==0)
                                            <a  class="btn btn-success" href="{{url('my-banking')}}" >Make Payment </a>
											@else
                                            <button name="submit"  class="btn btn-success" type="submit">Submit </button>
											@endif
											<a href="{{url('lottery/'.$lottery->id)}}" class="btn btn-danger" >Cancel </a>
					</form>	
                                        </div>
                                    </div>
                                     </div>
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
 <br/>
 <br/>
		
		
@endsection	