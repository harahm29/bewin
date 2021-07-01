@extends('layouts.admin')
@section('title','Lottery Create')
@section('content')
<style>
.cus_box_info
{
	background-color: #24313C; padding: 10px; margin: 10px;
}

.cus_body_box
{
	background-color: #1C2331; padding: 10px; margin: 10px;color:white; 
}

.cus_head_box
{
	height: 40px; padding-top:10px; margin-top: 0px; background-color:#1AB188;
}

.detail_cus  { padding-top: 7px; margin-top: 7px; }
.box_footer_cus  { background-color: #1AB188; padding-top: 7px; margin-top: 7px; }


.status_checkbox{
visibility: hidden;
}

/* SLIDE THREE */
.slideparam {
width: 80px;
height: 26px;
background: #333;
margin: 2px auto;

-webkit-border-radius: 50px;
-moz-border-radius: 50px;
border-radius: 50px;
position: relative;

-webkit-box-shadow: inset 0px 1px 1px rgba(0,0,0,0.5), 0px 1px 0px rgba(255,255,255,0.2);
-moz-box-shadow: inset 0px 1px 1px rgba(0,0,0,0.5), 0px 1px 0px rgba(255,255,255,0.2);
box-shadow: inset 0px 1px 1px rgba(0,0,0,0.5), 0px 1px 0px rgba(255,255,255,0.2);

}

.slideparam:after {
content: 'OFF';
font: 12px/26px Arial, sans-serif;
color: #7a121d;
position: absolute;
right: 10px;
z-index: 0;
font-weight: bold;
text-shadow: 1px 1px 0px rgba(255,255,255,.15);
}

.slideparam:before {
content: 'ON';
font: 12px/26px Arial, sans-serif;
color: #00bf00;
position: absolute;
left: 10px;
z-index: 0;
font-weight: bold;
}

.slideparam label {
display: block;
width: 34px;
height: 20px;
cursor: pointer;
-webkit-border-radius: 50px;
-moz-border-radius: 50px;
border-radius: 50px;
 
-webkit-transition: all .4s ease;
-moz-transition: all .4s ease;
-o-transition: all .4s ease;
-ms-transition: all .4s ease;
transition: all .4s ease;
position: absolute;
top: 3px;
left: 3px;
z-index: 1;

-webkit-box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.3);
-moz-box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.3);
box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.3);
background: #fff;


filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fcfff4', endColorstr='#b3bead',GradientType=0 );
}

.slideparam input[type=checkbox]:checked + label {
left: 43px;
}


 .slideparam input[type=checkbox]:checked + label:after {
   background: #27ae60;
}
 
.slideparam label:after {
   content:'';
   width: 10px;
   height: 10px;
   position: absolute;
   top: 5px;
   left: 12px;
   background: red;
   border-radius: 50%;
   box-shadow: inset 0px 1px 1px black, 0px 1px 0px rgba(255, 255, 255, 0.9);
 }

</style>
	<div class="main-panel">
			<div class="content">
				<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Lottery</h4>
						<ul class="breadcrumbs">
							<li class="nav-home">
								<a href="#">
									<i class="flaticon-home"></i>
								</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="{{url('lottery')}}">Lottery</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="#">Create</a>
							</li>
						</ul>
					</div>
					<div class="row">
						

						

						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="box-header" align="right">
									<a  align="right" href="{{url('match-code')}}" class="btn btn-success btn-sm" data-toggle="tooltip" title="Lottery Draw" ><b>Lottery Draw</b></a>
									<a align="right" href="{{url('lottery')}}" class="btn btn-primary btn-sm" data-toggle="tooltip" title="All Lottery" ><b><i class="fa fa-list" aria-hidden="true"></i> All Lottery</b></a>

									</div> 
								</div>
								<div class="card-body">
								@if(session('message'))
				<p class="alert alert-success">{{session('message')}}</p>
			@endif
									
									<form method="post" action="{{url('lottery')}}" id="exampleValidation" novalidate="novalidate" enctype="multipart/form-data" >
									@csrf
									<div class="card-body">
									<div class="form-group form-show-validation row">
										<label for="name" class="col-lg-3 ">Lottery name <span class="required-label">*</span></label>
										<div class="col-lg-6">
										<input  type="text" class="form-control" id="name" name="name" placeholder="Lottery Name" value="{{old('name')}}">
										<div class="text-danger">{{$errors->first('name')}}</div>							
										</div>
									</div>
									<div class="form-group form-show-validation row">
										<label for="image" class="col-lg-3 ">Banner/Image </label>
										<div class="col-lg-6">
										<input class="form-control" name="image" id="image" type="file" />
										<div class="text-danger"></div>
										</div>
										<div class="col-lg-2" >
										<img style="display:none;"  id="image_thumb" src="" width="50" />
										</div>
									</div>
								
									<div class="form-group form-show-validation row">
										<label for="validity" class="col-lg-3 ">Validity <span class="required-label">*</span></label>
										<div class="col-lg-6">
										<input class="form-control datepicker" name="validity" id="validity" type="text" />
										<div class="text-danger">{{$errors->first('validity')}}</div>
										</div>
										<div class="col-lg-2" >
										<img style="display:none;"  id="image_thumb" src="" width="50" />
										</div>
									</div>
									<div class="form-group form-show-validation row">
										<label for="draw_days" class="col-lg-3 ">Draw Days<span class="required-label">*</span></label>
										<div class="col-lg-6">
										 <label class="checkbox-inline">
										  <input type="checkbox" name="all_check" id="all_check" value="all_check"> All
										</label>&nbsp;&nbsp;&nbsp;
										@foreach($weekdays as $week)
										
										<label class="checkbox-inline">
										  <input type="checkbox" name="draw_days[]" class="draw_day" value="{{$week->full_day}}" > {{ucfirst($week->name)}}
										</label>&nbsp;&nbsp;&nbsp;
										@endforeach
										<!--<label class="checkbox-inline">
										  <input type="checkbox" name="draw_days[]" class="draw_day" value="mon"> Mon
										</label>&nbsp;&nbsp;&nbsp;
										<label class="checkbox-inline">
										  <input type="checkbox" name="draw_days[]" class="draw_day" value="tue"> Tue
										</label>&nbsp;&nbsp;&nbsp;
										<label class="checkbox-inline">
										  <input type="checkbox" name="draw_days[]" class="draw_day" value="wed"> Wed
										</label>&nbsp;&nbsp;&nbsp;
										<label class="checkbox-inline">
										  <input type="checkbox" name="draw_days[]" class="draw_day" value="thu"> Thu
										</label>&nbsp;&nbsp;&nbsp;
										<label class="checkbox-inline">
										  <input type="checkbox" name="draw_days[]" class="draw_day" value="fri"> Fri
										</label>&nbsp;&nbsp;&nbsp;
										<label class="checkbox-inline">
										  <input type="checkbox" name="draw_days[]" class="draw_day" value="sat"> Sat
										</label>&nbsp;&nbsp;&nbsp;
										<label class="checkbox-inline">
										  <input type="checkbox" name="draw_days[]" class="draw_day" value="sun"> Sun
										</label>&nbsp;&nbsp;&nbsp;
										-->
										<div class="text-danger">{{$errors->first('draw_days')}}</div>
										</div>
										<div class="col-lg-2" >
										<img style="display:none;"  id="image_thumb" src="" width="50" />
										</div>
									</div>
									<div class="form-group form-show-validation row">
										<label for="till_date" class="col-lg-3 ">Draw Timing <span class="required-label">*</span></label>
										<div class="col-lg-3">
										<select class="form-control" name="draw_timing" id="draw_timing" >
										<option value="">-Select-</option>
										@foreach($time_slots as $slot)
										<option value="{{$slot->id}}" {{old('draw_timing')==$slot->id?"selected":""}}>{{$slot->name}}</option>
										@endforeach
										</select>
										<div class="text-danger">{{$errors->first('draw_timing')}}</div>
										</div>
										<label for="till_date" class="col-lg-2 ">Start Lottery Time <span class="required-label">*</span></label>
										<div class="col-lg-3" >
										<select class="form-control" name="start_lottery_time" id="start_lottery_time" >
										<option value="">-Select-</option>
										@foreach($time_slots as $slot)
										<option value="{{$slot->id}}" {{old('start_lottery_time')==$slot->id?"selected":""}}>{{$slot->name}}</option>
										@endforeach
										</select>
										<div class="text-danger">{{$errors->first('start_lottery_time')}}</div>
										</div>
									</div>	
									<div class="form-group form-show-validation row">
										
										<label for="till_date" class="col-lg-3 ">End Lottery Time <span class="required-label">*</span></label>
										<div class="col-lg-3" >
										<select class="form-control" name="end_lottery_time" id="end_lottery_time" >
										<option value="">-Select-</option>
										@foreach($time_slots as $slot)
										<option value="{{$slot->id}}" {{old('end_lottery_time')==$slot->id?"selected":""}}>{{$slot->name}}</option>
										@endforeach
										</select>
										<div class="text-danger">{{$errors->first('end_lottery_time')}}</div>
										</div>
									</div>
										<div class="form-group form-show-validation row">
										<label for="ticket_price" class="col-lg-3 ">Ticket Price <span class="required-label">*</span></label>
										<div class="col-lg-6">
										<input class="form-control numeric_feild" name="ticket_price" id="ticket_price" type="text" />
										<div class="text-danger">{{$errors->first('ticket_price')}}</div>
										</div>
										<div class="col-lg-2" >
										<img style="display:none;"  id="image_thumb" src="" width="50" />
										</div>
									</div>
									<br>
									<fieldset>
									<legend style="font-size:14px;font-weight:bold;">Value Categories<hr></legend>
									</fieldset>
									
									<div class="form-group form-show-validation row">
										<label for="cat1_val" class="col-lg-3 "> </label>
										<div class="col-lg-3">
										<label > Values </label>
										</div>
										<div class="col-lg-2" >
										<label > Max no of winners </label>
										</div>
									</div>
									<div class="form-group form-show-validation row">
										<label for="cat1_val" class="col-lg-3 ">6+power ball (Jackpot)</label>
										<div class="col-lg-3">
										<input  type="text" class="form-control " id="cat1_val" name="cat1_val" placeholder="" value="{{old('cat1_val')}}">
										<div class="text-danger">{{$errors->first('end_lottery_time')}}</div>
										</div>
										<div class="col-lg-3" >
										<input  type="text" class="form-control numeric_feild" id="cat1_max_winner" name="cat1_max_winner" placeholder="" value="{{old('cat1_max_winner')}}">
										<div class="text-danger">{{$errors->first('cat1_max_winner')}}</div>
										</div>
									</div>
										<div class="form-group form-show-validation row">
										<label for="cat2_val" class="col-lg-3 ">6 of 6</label>
										<div class="col-lg-3">
										<input  type="text" class="form-control " id="cat2_val" name="cat2_val" placeholder="" value="{{old('cat2_val')}}">
										<div class="text-danger">{{$errors->first('cat2_val')}}</div>
										</div>
										<div class="col-lg-3" >
										<input  type="text" class="form-control numeric_feild" id="cat2_max_winner" name="cat2_max_winner" placeholder="" value="{{old('cat2_max_winner')}}">
										<div class="text-danger">{{$errors->first('cat2_max_winner')}}</div>
										</div>
									</div>
										<div class="form-group form-show-validation row">
										<label for="cat3_val" class="col-lg-3 ">5+power ball</label>
										<div class="col-lg-3">
										<input  type="text" class="form-control " id="cat3_val" name="cat3_val" placeholder="" value="{{old('cat3_val')}}">
										<div class="text-danger">{{$errors->first('cat3_val')}}</div>
										</div>
										<div class="col-lg-3" >
										<input  type="text" class="form-control numeric_feild" id="cat3_max_winner" name="cat3_max_winner" placeholder="" value="{{old('cat3_max_winner')}}">
										<div class="text-danger">{{$errors->first('cat3_max_winner')}}</div>
										</div>
									</div>
										<div class="form-group form-show-validation row">
										<label for="cat4_val" class="col-lg-3 ">5 of 6</label>
										<div class="col-lg-3">
										<input  type="text" class="form-control " id="cat4_val" name="cat4_val" placeholder="" value="{{old('cat4_val')}}">
										<div class="text-danger">{{$errors->first('cat4_val')}}</div>
										</div>
										<div class="col-lg-3" >
										<input  type="text" class="form-control numeric_feild" id="cat4_max_winner" name="cat4_max_winner" placeholder="" value="{{old('cat4_max_winner')}}">
										<div class="text-danger">{{$errors->first('cat4_max_winner')}}</div>
										</div>
									</div>
										<div class="form-group form-show-validation row">
										<label for="cat5_val" class="col-lg-3 ">4+power ball</label>
										<div class="col-lg-3">
										<input  type="text" class="form-control " id="cat5_val" name="cat5_val" placeholder="" value="{{old('cat5_val')}}">
										<div class="text-danger">{{$errors->first('cat5_val')}}</div>
										</div>
										<div class="col-lg-3" >
										<input  type="text" class="form-control numeric_feild" id="cat5_max_winner" name="cat5_max_winner" placeholder="" value="{{old('cat5_max_winner')}}">
										<div class="text-danger">{{$errors->first('cat5_max_winner')}}</div>
										</div>
									</div>
										<div class="form-group form-show-validation row">
										<label for="cat6_val" class="col-lg-3 ">4 of 6</label>
										<div class="col-lg-3">
										<input  type="text" class="form-control " id="cat6_val" name="cat6_val" placeholder="" value="{{old('cat6_val')}}">
										<div class="text-danger">{{$errors->first('cat6_val')}}</div>
										</div>
										<div class="col-lg-3" >
										<input  type="text" class="form-control numeric_feild" id="cat6_max_winner" name="cat6_max_winner" placeholder="" value="{{old('cat6_max_winner')}}">
										<div class="text-danger">{{$errors->first('cat6_max_winner')}}</div>
										</div>
									</div>
										<div class="form-group form-show-validation row">
										<label for="cat7_val" class="col-lg-3 ">3+power ball</label>
										<div class="col-lg-3">
										<input  type="text" class="form-control " id="cat7_val" name="cat7_val" placeholder="" value="{{old('cat7_val')}}">
										<div class="text-danger">{{$errors->first('cat7_val')}}</div>
										</div>
										<div class="col-lg-3" >
										<input  type="text" class="form-control numeric_feild" id="cat7_max_winner" name="cat7_max_winner" placeholder="" value="{{old('cat7_max_winner')}}">
										<div class="text-danger">{{$errors->first('cat7_max_winner')}}</div>
										</div>
									</div>
										<div class="form-group form-show-validation row">
										<label for="cat8_val" class="col-lg-3 ">3 of 6 </label>
										<div class="col-lg-3">
										<input  type="text" class="form-control " id="cat8_val" name="cat8_val" placeholder="" value="{{old('cat8_val')}}">
										<div class="text-danger">{{$errors->first('cat8_val')}}</div>
										</div>
										<div class="col-lg-3" >
										<input  type="text" class="form-control numeric_feild" id="cat8_max_winner" name="cat8_max_winner" placeholder="" value="{{old('cat8_max_winner')}}">
										<div class="text-danger">{{$errors->first('cat8_max_winner')}}</div>
										</div>
									</div>
										
																
									</div>
									<div class="card-action">
									<button type="submit" class="btn btn-success">Submit</button>
									<a href="{{url('lottery')}}" class="btn btn-danger">Cancel</a>
									</div>
								</form>

								
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
		</div>	
		
		
		<script>
		$(function() {
		  $(".datepicker").datepicker({ 
				autoclose: true, 
				todayHighlight: true
		  }).datepicker('update', new Date());
		});
		function all_check_auto()
		{
			var check_length = $(".draw_day:checked").length;
			
			
			if(check_length==7)
			{
				$("#all_check").prop("checked",true);
			}
			else
			{
				$("#all_check").prop("checked",false);
			}
		}
		$(document).ready(function(){
			$("#all_check").click(function(){
			
			var val = $("#all_check:checked").val();
			console.log(val);
			if(val=="all_check")
			{
				$(".draw_day").each(function(){
					$(this).prop("checked",true);
				});
			}
			else
			{
				$(".draw_day").each(function(){
				$(this).prop("checked",false);
			});
			}
			});
			
			$(".draw_day").click(function(){
			all_check_auto();
			
		});
		
		$.validator.addMethod("greaterThan",
			function (value, element, param) {
				  var $otherElement = $(param);
				  return parseInt(value, 10) > parseInt($otherElement.val(), 10);
			});
		$.validator.addMethod("lessThan",
			function (value, element, param) {
				  var $otherElement = $(param);
				  return parseInt(value, 10) < parseInt($otherElement.val(), 10);
			});
		
			  $("#exampleValidation").validate({
			validClass: "success",
			rules: {
				name: {
					required: true
				},
				ticket_price: {
					required: true
				},
				till_date: {
					required: true
				},
				draw_date: {
					required: true
				},
				cat1_val: {
					required: true
				},
				cat1_max_winner: {
					required: true
				},
				cat2_val: {
					required: true
				},
				cat2_max_winner: {
					required: true
				},
				cat3_val: {
					required: true
				},
				cat3_max_winner: {
					required: true
				},
				cat4_val: {
					required: true
				},
				cat4_max_winner: {
					required: true
				},
				cat5_val: {
					required: true
				},
				cat5_max_winner: {
					required: true
				},
				cat6_val: {
					required: true
				},
				cat6_max_winner: {
					required: true
				},
				cat7_val: {
					required: true
				},
				cat7_max_winner: {
					required: true
				},
				cat8_val: {
					required: true
				},
				cat8_max_winner: {
					required: true
				},
				"draw_day[]": {
					required: true
				},
				draw_timing: {
					required: true
				},
				start_lottery_time: {
					required: true
				},
				end_lottery_time: {
					required: true,
					lessThan:"#start_lottery_time"
				},
				
			},
			messages: { 
            "draw_day[]": "Please select at least 1 draw day.",
            "end_lottery_time": "End Lottery Time is Less than Start Lottery time.",
			},
			highlight: function(element) {
				$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
			},
			success: function(element) {
				$(element).closest('.form-group').removeClass('has-error').addClass('has-success');
			},
		});
		
		$(".delete_user").click(function(e){
    e.preventDefault();
	var id = $(this).attr('id');
	 bootbox.confirm({
		  message:"Are you sure you want to delete this user?",
		  buttons:{ cancel: {
            label: '<i class="fa fa-times"></i> Cancel'
			},
			confirm: {
				label: '<i class="fa fa-check"></i> Confirm'
			},
			  },
		    callback: function (result) {
				if(result){
						
			  $('#delete_form_'+id).submit();
				}
			}
		  })//confirm
 });
		// For view transaction //For view order Details
	$(".view").click(function(e){
		e.preventDefault();
		$("#view_modal").modal();
	  var transaction_id = $(this).attr('id');
	 
	  var url =  $(this).attr('href');
	  
	  $.ajax({
		  url:url,
		  data:{id:transaction_id},
		  type:"get",
		  success:function(data)
		  {
			  $(".view_body").html(data);
		  }
	  })
  });
   function readURL(input) 
	{
		if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function(e) {
		$('#image_thumb').attr('src', e.target.result);

		$('#image_thumb').hide();
		$('#image_thumb').fadeIn(650);
		}
	   reader.readAsDataURL(input.files[0]);
		}
	}

	$("#image").change(function() {
	readURL(this);
	}); 
		});

	</script>
		
@endsection	