@extends('layouts.admin')

@section('title','Lottery')

@section('content')

 <!-- Start Bottom Header -->

 <div class="page-area">

            <div class="breadcumb-overlay"></div>

            <div class="container">

                <div class="row">

                    <div class="col-md-12 col-sm-12 col-xs-12">

                        <div class="breadcrumb text-center">

                            <div class="section-headline text-center">

                                <h3>Lottery</h3>

                            </div>

                            <ul>

                                <li class="home-bread">Home</li>

                                <li>Lottery</li>

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

						<div class="section-headline text-center">

							<h3>Lottery Number</h3>

							<p>Dummy text is also used to demonstrate the appearance of different typefaces and layouts</p>

						</div>

					</div>

				</div> 

                 <div class="row">

                    <div class="lottery-content">

                        <!-- Single Lottery area  -->
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
                        @foreach($lotterys as $lottery)

						<form action="{{url('paypal')}}" method="post" id="from_{{$lottery->id}}" >

						@csrf
						  <div class="col-md-4 col-sm-4 col-xs-12">
                            <!-- fun_text  -->
                            <div class="single-ticket">
                                <span class="ticket-rate">{{$lottery->ticket_price}}CD</span>
                                <div class="ticket-image">
                                    <span class="win-price">Win price</span>
                                    <span class="win-money">${{$lottery->cat1_val}}k</span>
                                    <img src="{{url('admin/public/images/'.$lottery->image)}}" alt="">
                                </div>
                                <div class="ticket-text">
								@php 
								
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
									
								@endphp
                                    <h4 class="ticket-name">{{$lottery->name}} </h4>
                                   <span class="draw">Last Purchase: {{$end_time}}<br>Next Draw: {{$lottery_date}} {{$lottery->draw_timing}}</span>
								
                                   
								   @if($time_status==1)
                                    <a  class="ticket-btn btn-danger stop_lottery" style="background:red;" href="#" data-toggle="tooltip" title="Lottery Has Stop Now It Will be Open At {{$start_time}}">Stop Now</a> 
									@else
								     <a  class="ticket-btn " href="{{url('lottery/'.$lottery->id)}}">Play Now </a>
								@endif
								
									<br>
									
                                </div>
                            </div>
                        </div>
						
						
						
					

						


		

		<input type="hidden" name="lottery_select_val" id="lottery_select_val_{{$lottery->id}}" value="" />

		<input type="hidden" name="lottery_select_val_power_ball" id="lottery_select_val_power_ball_{{$lottery->id}}" value="" />

			</form>			

                        @endforeach

                        <!-- Single Lottery area  -->

                      

                        

                    </div>

					 

                </div>

				 {{ $lotterys->appends(request()->query())->links() }} 

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

			// Ticket button

			$(".ticket-btn1").click(function(e){

				check_login();

				var lottery_id = $(this).attr('lottery_id');

				var user_id = $("#user_id").val().trim();

				var mannual_length_li = $("#self-number-mannual-"+lottery_id+" li").length;

				var auto_length_li = $("#self-number-auto-"+lottery_id+" li").length;

				var total_length = mannual_length_li + auto_length_li;

				if(total_length < 1)

				{

					e.preventDefault();

					bootbox.alert("Please select atleat one lottery ball to play game.");

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

			

			/* $(".auto").click(function(e){

				e.preventDefault();

				check_login();

				var lottery_id = $("#lottery_id").val();

				var ul_id = $(this).closest("ul").attr('lottery_id');

				var radio_check_val = $("input[name='auto-num-"+ul_id+"']:checked").val();

				

				$(".mannual_ul_"+ul_id+" li").removeClass("active");

				$("#self-number-mannual-"+ul_id).html('');

				

				$("#auto-num-"+ul_id).prop("checked",true);

				$("#manual-num-"+ul_id).prop("checked",false);

				var length_li = $(".auto_ul_"+ul_id+" li.active").length;

				if(radio_check_val == null || radio_check_val == null )

				{

					bootbox.alert("Pleas select Lottery Radio button ");

					return false;

				}

				else

				{

					$("#auto_power_ball_button_"+ul_id).prop("disabled",false);

					if(length_li > 5)

					{

						bootbox.alert("You can select only 6 no to play lottery game");

						return false;

					}

					else

					{

						

						var li_val = $(this).text();

						if(!$(this).hasClass("active"))

						{

						$(this).addClass("active");

						$("#self-number-auto-"+ul_id).append('<li class="auto_select_result auto_select_li_'+li_val+'"><a href="#">'+li_val+'</a></li>');

						}

						else

						{

						$(this).removeClass("active");

						$(".auto_select_li_"+li_val).remove();

						}

					

						

						

					}

				}

			}); */

			

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