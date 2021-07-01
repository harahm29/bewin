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
                        @foreach($lotterys as $lottery)
						<form action="{{url('paypal')}}" method="post" id="from_{{$lottery->id}}" >
						@csrf
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="single-lottery">
                                <div class="lottery-top">
                                    <span class="ticket-rate">{{$lottery->ticket_price}}CD</span>
                                    <h4>{{$lottery->name}}</h4>
                                    <span class="win-price">Win price</span>
                                    <span class="win-money">${{$lottery->cat1_val}}k</span>
                                    <div class="buy-ticket-btn">
                                        <button style="padding-bottom: 1px;padding-top: 1px;" lottery_id="{{$lottery->id}}"  class="ticket-btn btn-sm " href="#">  Play Now </button>
                                    </div>
                                </div>
								<input type="hidden" name="lottery_id" id="lottery_id" value="{{$lottery->id}}" />
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
										<button id="auto_power_ball_button_{{$lottery->id}}" lottery_id="{{$lottery->id}}"  class="btn btn-sm btn-warning auto-power-ball" disabled>Select Power Ball</button>
                                    </div>
                                </div>
                                <div class="manual-number">
                                    <div class="number-top">
                                        <input   type="radio" id="manual-num-{{$lottery->id}}" name="auto-num-{{$lottery->id}}" value="mannual{{$lottery->id}}" > 
                                        <label class="radio_select" radio_type="mannual" auto_random_no_radio="{{$lottery->id}}" for="manual-num-{{$lottery->id}}">
                                        Manual Number Selected 
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
										<button id="mannual_power_ball_button_{{$lottery->id}}" lottery_id="{{$lottery->id}}"  class="btn btn-sm btn-warning mannual-power-ball" disabled >Select Power Ball</button>
                                    </div>
                                    <div class="self-number">
                                        <div class="self-ticket">
                                            <span>Your Ticket Number :</span>
                                            <ul id="self-number-auto-{{$lottery->id}}" class="self-number">
                                               
                                            </ul>
											<ul id="self-number-mannual-{{$lottery->id}}" class="self-number">
                                               
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
						
						<!-- Model Start -->
		<div class="modal fade" id="auto_power_ball_modal_{{$lottery->id}}" role="dialog">
			<div class="modal-dialog"> 
									
				<!-- Modal content-->
				<div class="modal-content">
				<div class="modal-header bg-success" style="color:#fff;">
				 <h4 class="modal-title"><i class="fas fa-info-circle"></i> Power Ball Selection</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				   
				</div>
					<div class="modal-body" align="center">
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
					<div class="modal-footer">
						<input data-dismiss="modal" value="Close" class="btn btn-primary" >
					</div>

				</div>
			</div>
		</div>
		<!-- End Model Start -->
		<!-- Model Start -->
		<div class="modal fade" id="mannual_power_ball_modal_{{$lottery->id}}" role="dialog">
			<div class="modal-dialog"> 
									
				<!-- Modal content-->
				<div class="modal-content">
				<div class="modal-header bg-success" style="color:#fff;">
				 <h4 class="modal-title"><i class="fas fa-info-circle"></i> Power Ball Selection</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				   
				</div>
					<div class="modal-body" align="center">
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
					<div class="modal-footer">
						<input data-dismiss="modal" value="Close" class="btn btn-primary" >
					</div>

				</div>
			</div>
		</div>
		<!-- End Model Start -->
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
			$(".ticket-btn").click(function(e){
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
				/* var lottery_id = $("#auto_hidden_lottery_id").val();
				var ul_id = $(this).closest("ul").attr('lottery_id');
				var radio_check_val = $("input[name='auto-num-"+ul_id+"']:checked").val();
				
				$(".mannual_ul_"+ul_id+" li").removeClass("active");
				$("#self-number-mannual-"+ul_id).html('');
				
				$("#auto-num-"+ul_id).prop("checked",true);
				$("#manual-num-"+ul_id).prop("checked",false);
				var length_li = $(".auto_power_ball_ul_"+ul_id+" li.active").length;
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
						$(".auto_powet_ball_li_"+li_val).remove();
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
						$("#self-number-auto-"+ul_id).append('<li  class="auto_power_ball_result auto_powet_ball_li_'+li_val+'"><a style="background:blue;" href="#">'+li_val+'</a></li>');
						}
						else
						{
						$(this).removeClass("active");
						$(".auto_powet_ball_li_"+li_val).remove();
						}
					
						
						
					}
				} */
				
				
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