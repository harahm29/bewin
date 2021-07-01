@extends('layouts.admin')
@section('title','Lottery View')
@section('content')
<style>
.ticket-price
{
	background: #e62e7c;color: #fff;color: #fff;
    font-weight: 600;
    font-size: 18px;
    padding: 2px 15px;
    line-height: 26px;
    border-radius: 0px 3px 3px 0px;
}
</style>
@php 
								
								$draw_days_array = explode(",",$lottery->draw_days);
									 $today = strtolower(date("D"));
									 $today_date = (date("w"));
									// echo "<br>today_date >> ".$today_date;exit;
									 $count = count($draw_days_array);
									// echo "<br>count >> ".$count;
									 if(array_search($today,$draw_days_array))
									 {
										 $day_status = 1;
										$key = $draw_days_array[array_search($today,$draw_days_array)];
										
										// echo "<br>count >> ".$count;
										// echo "<br>array_search >> ".array_search($today,$draw_days_array);exit;
										if(($count -1) > array_search($today,$draw_days_array))
										{
											 $day = $draw_days_array[array_search($today,$draw_days_array)+1];
										}
										else
										{
											$day = $draw_days_array[0];
										}
										
									 }
									 else
									 {
										$day_status = 0;
										$array = ["sun"=>0,"mon"=>1,"tue"=>2,"wed"=>3,"thu"=>4,"fri"=>5,"sat"=>6]; 
										$key = $array[$draw_days_array[$count-1]];
										if($key > $today_date)
											$day = $draw_days_array[$count-1];
										else
											$day = $draw_days_array[0];
									 }
								    //echo $day;
								 	$current_time = date("h a");
									$timeSlotStart = DB::table("time_slots")->where(['id'=>$lottery->start_lottery_time])->first();
									$start_time = $timeSlotStart->name;
									$timeSlot = DB::table("time_slots")->where(['id'=>$lottery->end_lottery_time])->first();
								 	$end_time = $timeSlot->name;
									$time1 = DateTime::createFromFormat('H a', $current_time);
									// print_r($time1);
									// exit;
									$time2 = DateTime::createFromFormat('H a', $start_time);
									$time3 = DateTime::createFromFormat('H a', $end_time);
									if($day_status==1 && ($time1 >= $time3) && ($time1 <= $time2))
									{
									    $time_status = 1;
									}
									else
										$time_status = 0;
								@endphp
 <!-- Start Bottom Header -->
 <div class="page-area">
            <div class="breadcumb-overlay"></div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="breadcrumb text-center">
                            <div class="section-headline text-center">
                                <h3>Lottery View</h3>
                            </div>
                            <ul>
                                <li class="home-bread">Home</li>
                                <li>Lottery View</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Header -->
  <!-- Start Number area -->
  <div class="lottery-area area-padding-2">
            <div class="container">
                 <div class="row">
				 @if(session('message'))
				<p class="alert alert-success">{{session('message')}}</p>
				@endif
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="section-headline ">
							<h3>{{$lottery->name}}</h3>
							
						</div>
					</div>
					<form action="{{url('paypal')}}" method="post" id="lottery_form" >
						@csrf
					
					
					<div class="col-md-6">
					</div>
					<div class="col-md-6">
					<h6>Winning Prize</h6>
					</div>
					
					<div class="col-md-6">
					<table   class="table"> 
					<tr>  
                    <td ><label>Winning Prize</label></td>  
                    <td >${{$lottery->cat1_val}}</td>  
                    </tr>
					<tr>  
                    <td ><label>Next Draw Date</label></td>  
                    <td >{{date("d M Y",strtotime("next $day"))}} {{$lottery->draw_timing}}</td>  
                    </tr>
					<tr>  
                    <td ><label>Lottery Price</label></td>  
                    <td ><span class="ticket-price" >{{$lottery->ticket_price}}CD<input type="hidden"   name="amount" id="amount" value="{{$lottery->ticket_price}}" /></span></td>  
                    </tr>
					<tr>  
                    <td ><label>No. of Ticket Want To Purchase</label></td>  
                    <td ><input type="number" min="1" max="99" class="form-control numeric_feild ticket_no" name="ticket_no" id="ticket_no" /></td>  
                    </tr>
					</table>
					</div>
					
					<div class="col-md-6">
					
				    <table class="table"> 
					
					
					<tr>  
                    <td ><label>6+power ball</label></td>  
                    <td >{{$lottery->cat1_val}}</td>  
					<td ><label>6 of 6</label></td>  
                    <td >{{$lottery->cat2_val}}</td>  
                    </tr>
					
					<tr>  
                    <td ><label>5+power ball</label></td>  
                    <td >{{$lottery->cat3_val}}</td>  
					<td ><label>5 of 6</label></td>  
                    <td >{{$lottery->cat4_val}}</td>  
                    </tr>
					
					<tr>  
                    <td ><label>4+power ball</label></td>  
                    <td >{{$lottery->cat5_val}}</td>
					<td ><label>4 of 6</label></td>  
                    <td >{{$lottery->cat6_val}}</td> 					
                    </tr>
					
					<tr>  
                    <td ><label>3+power ball</label></td>  
                    <td >{{$lottery->cat7_val}}</td>
					<td ><label>3 of 6</label></td>  
                    <td >{{$lottery->cat8_val}}</td> 					
                    </tr>
					</table>
					</div>
					
					
					
				</div> 
                 <div class="row">
                    <div class="lottery-content">
                        <!-- Single Lottery area  -->
                        <div class="col-md-6">
						<div class="single-lottery">
						  <div class="auto-number">
                                    <div class="number-top">
                                        <input  type="radio" id="auto-num-{{$lottery->id}}" name="auto-num-{{$lottery->id}}" value="auto{{$lottery->id}}"  >
                                        <label class="radio_select" radio_type="auto" auto_random_no_radio="{{$lottery->id}}" for="auto-num-{{$lottery->id}}">
                                        Auto Number Generated
                                        </label>
										<span data-toggle="tooltip" title="" class=" btn-sm" data-original-title="Automatically Random Number will be Generated" style="font-size: 16px;">
										<i class="fas fa-info-circle"></i>
										</span>
                                    </div>
                                    <div class="number-all">
                                        <ul   id="auto_{{$lottery->id}}" lottery_id="{{$lottery->id}}"  class="number-serial auto_ul_{{$lottery->id}}">
                                       
                                        @for($i=1;$i<=50;$i++)
                                            <li class=" auto"><a  href="#">{{$i}}</a></li>
                                        @endfor
                                        </ul>
										<br>
										<span class="text-primary">Power Ball</span>
										
									
										<div class=" ">
										 <div class="number-all">
										 <input type="hidden" name="auto_hidden_lottery_id" id="auto_hidden_lottery_id" value="{{$lottery->id}}" />
										   <ul id="auto_power_ball_ul_{{$lottery->id}}" lottery_id="{{$lottery->id}}" class="number-serial auto_power_ball_ul_{{$lottery->id}}">
												@for($i=1;$i<=25;$i++)
													<li class=" auto_power_ball_li"><a href="#">{{$i}}</a></li>
												@endfor
												
											</ul>
										 </div>
									</div>
                                    </div>
                          </div>
                        </div>
						  <div id="auto_message" style="display:none;">
								<span class="text-danger"><b>Auto Generated No Will Be Sent To Your Mail Id After Lottery Ticket Price</b></span><br>
						  </div>
						</div>
						<div class="col-md-6">
						<div class="single-lottery">
						  <div class="manual-number">
                                    <div class="number-top">
                                        <input   type="radio" id="manual-num-{{$lottery->id}}" name="auto-num-{{$lottery->id}}" value="mannual{{$lottery->id}}" > 
                                        <label class="radio_select" radio_type="mannual" auto_random_no_radio="{{$lottery->id}}" for="manual-num-{{$lottery->id}}">
                                        Manual Number Generated 
                                        </label>
										<span data-toggle="tooltip" title="" class=" btn-sm" data-original-title="Type 6 Number Selected Manually">
										<i class="fas fa-info-circle"></i>
										</span>
                                    </div>
                                    <div class="number-all">
                                        <ul  id="mannual_{{$lottery->id}}" lottery_id="{{$lottery->id}}" class="number-serial mannual_ul_{{$lottery->id}}">
                                        @for($i=1;$i<=50;$i++)
                                            <li class=" mannual"><a href="#">{{$i}}</a></li>
                                        @endfor
                                        </ul>
										<br>
										<span class="text-primary">Power Ball</span>
										<div class=" ">
										 <div class="number-all">
										 <input type="hidden" name="mannual_hidden_lottery_id" id="mannual_hidden_lottery_id" value="{{$lottery->id}}" />
										   <ul id="mannual_power_ball_ul_{{$lottery->id}}" lottery_id="{{$lottery->id}}" class="number-serial mannual_power_ball_ul_{{$lottery->id}}">
												@for($i=1;$i<=25;$i++)
													<li class=" mannual_power_ball_li"><a href="#">{{$i}}</a></li>
												@endfor
												
											</ul>
										 </div>
										</div>
                                    </div>
                                    
                         </div>
                         </div>
						</div>
						<div class="col-md-12">
						<div class="self-number">
                                        <div class="self-ticket">
                                            <span>Selected Numbers :</span>
                                            <ul id="self-number-auto-{{$lottery->id}}" class="self-number">
                                               
                                            </ul>
											<ul id="self-number-mannual-{{$lottery->id}}" class="self-number">
                                               
                                            </ul>
                                        </div>
                        </div>
						
						<input type="hidden" name="lottery_id" id="lottery_id" value="{{$lottery->id}}" />
                        <div class="col-md-12">
						<table align="center" style="width:50%;" class="table"> 
						<tr>  
						<td ><label>Total Price</label></td>  
						<td id="total_price"></td>  
						<input type="hidden" name="total_price" class="total_price" />
						</tr>
						<tr>  
						</table>
						</div> 
						
						<table align="center" style="width:50%;" class="table"> 
						
						<tr>  
						<td ><button class="btn btn-success btn-lg btn-block submit-btn" type="submit" lottery_id="{{$lottery->id}}" >Next </button></td>  
						<td ><button class="btn btn-danger btn-lg btn-block" type="reset">Cancel </button></td>  
						
						</tr>
						<tr>  
						</table>
						</div>
						
						
		
		<!-- End Model Start -->
		<input type="hidden" name="lottery_select_val" id="lottery_select_val_{{$lottery->id}}" value="" />
		<input type="hidden" name="lottery_select_val_power_ball" id="lottery_select_val_power_ball_{{$lottery->id}}" value="" />
			</form>			
                        
                        <!-- Single Lottery area  -->
                      
                        
                    </div>
					 
                </div>
				 
            </div>
        </div>
		
	<input type="hidden" name="user_id" id="user_id" value="@if(Auth::check()){{Auth::user()->id}}@else 0 @endif" />
	
        <!-- End Number area -->	
		
		<!-- jquery latest version -->
		<script src="{{url('public/frontend/js/vendor/jquery-1.12.4.min.js')}}"></script>
		<script>
		function check_login()
		{
			var user_id = $("#user_id").val().trim();
			if(user_id==0)
				{
					
					location.href = "{{url('signin')}}";
				}
			
		}
		
		$(document).ready(function(){
			$(".ticket_no").on("keyup change",function(){
				
				var lottery_id = "{{$lottery->id}}";
				var val = parseInt($(this).val());
				var amount = parseFloat($("#amount").val());
				
				if(isNaN(val))
					val = 0;
				if(isNaN(amount))
					amount = 0;
				console.log("amount >> "+amount);
				console.log("val >> "+val);
				if(val > 1)
				{
					$(".auto-number").hide();
					$("#auto_message").show();
					$(".auto_ul_"+lottery_id+" li").removeClass("active");
					$(".auto_power_ball_li").removeClass("active");
				$("#self-number-auto-"+lottery_id).html('');
				
				$("#auto-num-"+lottery_id).prop("checked",false);
				}
				else
				{
					$(".auto-number").show();
					$("#auto_message").hide();
				}
				if(val >=1 && val<= 99)
				{
				var total = val * amount;
					$("#total_price").text("$"+total);
					$(".total_price").val("$"+total);
				}
				else
				{
					$("#total_price").text("$"+0);
				    $(".total_price").val("$"+0);
				}
				
			});
			$("#lottery_form").validate({
			validClass: "success",
			rules: {
				ticket_no: {
					required: true,
					min:1,
					max:99
				},
				total_price: {
					required: true
				},
				
				
			},
			 
			highlight: function(element) {
				$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
			},
			success: function(element) {
				$(element).closest('.form-group').removeClass('has-error').addClass('has-success');
			},
		});
		 
			// Ticket button
			$(".submit-btn").click(function(e){
				check_login();
				var lottery_id = $(this).attr('lottery_id');
				var user_id = $("#user_id").val().trim();
				var mannual_length_li = $("#self-number-mannual-"+lottery_id+" li").length;
				var auto_length_li = $("#self-number-auto-"+lottery_id+" li").length;
				var total_length = mannual_length_li + auto_length_li;
				var token_no = $("#token_no").val();
				if(token_no <= 1)
				{
					if(total_length < 1)
					{
						e.preventDefault();
						bootbox.alert("Please select atleat one lottery ball to play game.");
					}
				}
				
				if(user_id==0)
				{
					e.preventDefault();
					location.href = "{{url('signin')}}";
				}
				else
				{
					// location.href = "{{url('paypal/create?id="+lottery_id+"')}}";
					// if(mannual_length_li > 0)
					// {
						// $("#self-number-mannual-"+lottery_id+" li");
					// }
				//	e.preventDefault(); //mannual_powet_ball_li_
					if(auto_length_li > 0) 
					{
					var auto_result_val = '';
					var auto_result_power_ball = '';
					$("#self-number-auto-"+lottery_id+" li.auto_select_result").each(function(){
						var val = $(this).text(); 
						auto_result_val += val +","; 
					});
					$("#self-number-auto-"+lottery_id+" li.auto_power_ball_result").each(function(){
						var val = $(this).text(); 
						auto_result_power_ball += val +","; 
					});
					}
					else
					{
						var auto_result_val = '';
						var auto_result_power_ball = '';
						$("#self-number-mannual-"+lottery_id+" li").each(function(){
							var val = $(this).text(); 
							auto_result_val += val +","; 
						});
						$("#self-number-auto-"+lottery_id+" li.mannual_power_ball_result").each(function(){
						var val = $(this).text(); 
						auto_result_power_ball += val +","; 
					});
					}
					str = auto_result_val.replace(/,\s*$/, "");
					str1 = auto_result_power_ball.replace(/,\s*$/, "");
					$("#lottery_select_val_"+lottery_id).val(str);
					$("#lottery_select_val_power_ball_"+lottery_id).val(str1);
					console.log("str >> "+str);
					$("#form_"+lottery_id).submit();
					// console.log('from_submit');
				}
				
				
				console.log("auto_result_val >> "+auto_result_val);
				console.log("auto_result_power_ball >> "+auto_result_power_ball);
				console.log("total_length >> "+total_length);
				console.log("lottery_id >> "+lottery_id);
				console.log("user_id >> "+user_id);
			});
			
			
			
			
			
			
			
			
			$(".auto-power-ball").click(function(e){
				e.preventDefault();
			//	$("#auto_power_ball_ul_  li").removeClass("active");
				var lottery_id = $(this).attr('lottery_id');
				//var auto_power_ball_modal = $("#auto_power_ball_modal").val();
				
				$("#auto_power_ball_modal_"+lottery_id).modal('show');
				$("#auto_hidden_lottery_id").val(lottery_id);
				//$("#auto_power_ball_ul_").attr('lottery_id',lottery_id);
				check_login();
			});
			
				$(".auto_power_ball_li").click(function(e){
				e.preventDefault();
				check_login();
				
				
			});
			$(".mannual-power-ball").click(function(e){
				e.preventDefault();
				check_login();
				var lottery_id = $(this).attr('lottery_id');
				
				$("#mannual_power_ball_modal_"+lottery_id).modal('show');
				$("#mannual_hidden_lottery_id").val(lottery_id);
				
				
			});
			
				$(".mannual_power_ball_li").click(function(e){
				e.preventDefault();
				check_login();
				var lottery_id = $("#mannual_hidden_lottery_id").val();
				var ul_id = $(this).closest("ul").attr('lottery_id');
				var radio_check_val = $("input[name='auto-num-"+ul_id+"']:checked").val();
				
				$(".auto_ul_"+ul_id+" li").removeClass("active");
				$("#self-number-auto-"+ul_id).html('');
				$(".auto_power_ball_li").removeClass("active");
				$("#auto-num-"+ul_id).prop("checked",false);
				$("#manual-num-"+ul_id).prop("checked",true);
				var length_li = $(".mannual_power_ball_ul_"+ul_id+" li.active").length;
				if(radio_check_val == null || radio_check_val == null )
				{
					bootbox.alert("Pleas select Lottery Radio button ");
					return false;
				}
				else
				{
					if(length_li > 0)
					{
						var li_val = $(this).text();
						if(!$(this).hasClass("active"))
						{
						
						}
						else
						{
						$(this).removeClass("active");
						$(".mannual_powet_ball_li_"+li_val).remove();
						}
						bootbox.alert("You can select only 1 no to play lottery game");
						
						return false;
					}
					
					else
					{
						var li_val = $(this).text();
						if(!$(this).hasClass("active"))
						{
						$(this).addClass("active");
						$("#self-number-mannual-"+ul_id).append('<li class="mannual_power_ball_result mannual_powet_ball_li_'+li_val+'"><a style="background:blue;" href="#">'+li_val+'</a></li>');
						}
						else
						{
						$(this).removeClass("active");
						$(".mannual_powet_ball_li_"+li_val).remove();
						}
					
						
						
					}
				}
				
				
			});
			
			
			$(".mannual").click(function(e){
				e.preventDefault();
				check_login();
				var lottery_id = $("#lottery_id").val();
				var ul_id = $(this).closest("ul").attr('lottery_id');
				var radio_check_val = $("input[name='auto-num-"+ul_id+"']:checked").val();
				
				$(".auto_ul_"+ul_id+" li").removeClass("active");
				$("#self-number-auto-"+ul_id).html('');
				
				$("#auto-num-"+ul_id).prop("checked",false);
				$("#manual-num-"+ul_id).prop("checked",true);
				$(".auto_power_ball_li").removeClass("active");
				
				var length_li = $(".mannual_ul_"+ul_id+" li.active").length;
				if(radio_check_val == null || radio_check_val == null )
				{
					bootbox.alert("Pleas select Lottery Radio button ");
					return false;
				}
				else
				{
					$("#mannual_power_ball_button_"+ul_id).prop("disabled",false);
					if(length_li > 5)
					{
						bootbox.alert("You can select only 6 no to play lottery game");
						var li_val = $(this).text();
						if(!$(this).hasClass("active"))
						{
						
						}
						else
						{
						$(this).removeClass("active");
						$(".mannual_select_li_"+li_val).remove();
						}
						return false;
					}
					else
					{
						var li_val = $(this).text();
						if(!$(this).hasClass("active"))
						{
						$(this).addClass("active");
						$("#self-number-mannual-"+ul_id).append('<li class="mannual_select_result mannual_select_li_'+li_val+'"><a href="#">'+li_val+'</a></li>');
						}
						else
						{
						$(this).removeClass("active");
						$(".mannual_select_li_"+li_val).remove();
						}
					
						
						
					}
				}
				
				console.log(length_li);
				console.log("ul_id >> "+ul_id);
				console.log("lottery_id >> "+lottery_id);
				console.log("radio_check_val >> "+radio_check_val);
			});
			$(".radio_select").click(function(){
				check_login();
				var auto_random_no_radio = $(this).attr('auto_random_no_radio');
				var radio_type = $(this).attr('radio_type');
				
				if(radio_type=='auto')
				{
					$("#auto-num-"+auto_random_no_radio).prop("checked",true);
					$("#manual-num-"+auto_random_no_radio).prop("checked",false);
					$(".mannual_power_ball_li").removeClass("active");
				}
				else
				{
					$("#auto-num-"+auto_random_no_radio).prop("checked",false);
					$("#manual-num-"+auto_random_no_radio).prop("checked",true);

				}
				var radio_val = $("input[name='auto-num-"+auto_random_no_radio+"']:checked").val();
				var lottery_id = $("#lottery_id").val();
				console.log("radio_type >> "+radio_type);
				console.log("radio_val >> "+radio_val);
				console.log("auto_random_no_radio >> "+auto_random_no_radio);
				// alert(radio_val);
				// alert("auto"+auto_random_no_radio);
				
				radio_function(radio_val,auto_random_no_radio);
			});
		})
		function radio_function(radio_val,auto_random_no_radio)
		{
			
			if(radio_val == "auto"+auto_random_no_radio)
				{
					$("#auto_power_ball_button_"+auto_random_no_radio).prop("disabled",false);
					$(".auto_ul_"+auto_random_no_radio+" li").removeClass("active");
					$(".auto_power_ball_ul_"+auto_random_no_radio+" li").removeClass("active");
					
					$("#self-number-"+auto_random_no_radio).html('');
					$("#self-number-mannual-"+auto_random_no_radio).html('');
					$(".mannual_ul_"+auto_random_no_radio+" li").removeClass("active");
					
					// $("#auto-num-"+auto_random_no_radio).prop("checked",true);
					// $("#manual-num-"+auto_random_no_radio).prop("checked",false);
					
					$(".auto_ul_"+auto_random_no_radio).each(function() {
					 var liArr = $(this).children("li");
					 
					  console.log("liArr >> "+liArr);
					  $(liArr[Math.floor(Math.random() * liArr.length)]).addClass('active');
					  $(liArr[Math.floor(Math.random() * liArr.length)]).addClass('active');
					  $(liArr[Math.floor(Math.random() * liArr.length)]).addClass('active');
					  $(liArr[Math.floor(Math.random() * liArr.length)]).addClass('active');
					  $(liArr[Math.floor(Math.random() * liArr.length)]).addClass('active');
					  $(liArr[Math.floor(Math.random() * liArr.length)]).addClass('active');
					  
					});
					$(".auto_power_ball_ul_"+auto_random_no_radio).each(function() {
					 var liArr = $(this).children("li");
					 
					  console.log("liArr >> "+liArr);
					  $(liArr[Math.floor(Math.random() * liArr.length)]).addClass('active');
					  
					});
					
					
					
					var i=0;
					var auto_li_val=0;
					$("#self-number-auto-"+auto_random_no_radio).html('');
					$(".auto_ul_"+auto_random_no_radio+" li.active").each(function(){
						var val = $(this).text(); 
						$("#self-number-auto-"+auto_random_no_radio).append('<li class="auto_select_result auto_select_li_'+val+'"><a href="#">'+val+'</a></li>');
						 
					});
				
					
					$(".auto_power_ball_ul_"+auto_random_no_radio+" li.active").each(function(){
						var val1 = $(this).text(); 
						$("#self-number-auto-"+auto_random_no_radio).append('<li  class="auto_power_ball_result auto_powet_ball_li_'+val1+'"><a style="background:blue;" href="#">'+val1+'</a></li>');
						 
					});

					console.log("auto_li_val >> "+auto_li_val);
					
					
				}
				else
				{
					$(".mannual_ul_"+auto_random_no_radio+" li").removeClass("active");
					
					$(".auto_ul_"+auto_random_no_radio+" li").removeClass("active");
					// $("#manual-num-"+auto_random_no_radio).prop("checked",true);
					// $("#auto-num-"+auto_random_no_radio).prop("checked",false);
					$("#self-number-"+auto_random_no_radio).html('');
					console.log("auto no >> ");
				}
		}
		</script>
		
@endsection	