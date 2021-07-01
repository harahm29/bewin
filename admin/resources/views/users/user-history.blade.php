@extends('layouts.admin')
@section('title','User History')
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
.ball
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
}
</style>
	<div class="main-panel">
			<div class="content">
				<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">User History</h4>
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
								<a href="{{url()->current()}}">User History</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="#">List</a>
							</li>
						</ul>
					</div>
					<div class="row">
						

						

						<div class="col-md-12">
							<div class="card">
								<div class="card-header"> 
									<div class="box-header" align="right"><h2 style="float:left;">{{$user->first_name ?? ""}} {{$user->last_name ?? ""}}</h2>
									<a  align="right" href="{{url()->previous()}}" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Back" ><b><i class="fa fa-backspace" aria-hidden="true"></i> Back</b></a>

									</div> 
								</div>
								<div class="card-body">
								@if(session('message'))
								<p class="alert alert-success">{{session('message')}}</p>
								@endif
								<div class="table-responsive">
										<table  id="example1" class="display table table-striped table-hover"  >

										<thead>
										<tr>
										<th>#</th>
										<th>Date</th>
										<th>Lottery Name</th>
										<th>Lottery No</th>
										<th>Selected No</th>
										<th>Powerball</th>
										<th>Price</th>
										<th>Draw Date & Time</th>
										<th>Status</th>
										<th>Action</th>
										</tr>
										</thead>

										<tbody>
										<tr>
										@php $i=1; @endphp
											@foreach($lotterys as $data)
											
												   <td>{{$i}}</td>
												   <td>{{date("d-m-Y",strtotime($data->today_date))}}</td>
												   <td>{{$data->lottery_name}}</td>
												   
												   <td >
												   @if($data->lottery_draw_no)
												   @php $lottery_array = explode(",",$data->lottery_draw_no); @endphp
														<span class="text-success">{{$data->lottery_draw_no}}<span>, <span class="text-primary" data-toggle="tooltip" title="Powerball">{{$data->lottery_draw_power_ball}}</span>
													@else
														@php $lottery_array = array(); @endphp
													@endif
												   </td>
												   <td >
												   @php $lottery_array_new = explode(",",$data->lottery_no); @endphp
												   @foreach($lottery_array_new as $lottery_new)
													 @if(in_array($lottery_new,$lottery_array)) 
													 <span class="text-success">{{$lottery_new}}@if($loop->iteration<5),@endif </span>
													 @else
														<span >{{$lottery_new}}@if($loop->iteration<5),@endif </span> 
													@endif  
													@endforeach
												   </td>
												   <td >
												   @if($data->lottery_draw_power_ball && $data->lottery_draw_power_ball==$data->power_ball_no) 
													   <span class="text-primary" data-toggle="tooltip" title="Powerball">{{$data->power_ball_no}} 
												   @else
													   {{$data->power_ball_no}}
												   @endif
												   </td>
												    <td >${{$data->lottery_price}}</td>
												   <td>
												   <i data-toggle="tooltip" title="@if($data->draw_date==null) @else {{date('d-m-Y h A',strtotime($data->draw_date))}} @endif" class="fa fa-eye text-primary" aria-hidden="true"></i> 
												   </td>
												   <td >
												   	<i data-toggle="tooltip" title="@if($data->win_id > 0){{$data->winning_category}} ${{$data->winning_price}} @else Not Winning Ticket @endif" class="fa fa-eye @if($data->win_id > 0) text-success @else text-danger @endif" aria-hidden="true"></i> 
												   </td>
												   
												   <td> 
												   <form method="post" id="delete_form_{{$data->id}}" action="{{url('addlotteryticket/'.$data->id)}}"  style="width:150px;">
													@method('DELETE')
													@csrf
												<input type="hidden" name="id" id="id" value="{{$data->id}}" />
											
												<button type="button" id="{{$data->id}}" href="{{url('addlotteryticket/'.$data->id)}}"  class="btn btn-sm btn-info view"data-toggle="tooltip" title="View">	<i class="fa fa-eye" aria-hidden="true"></i></button>  
												
												 <!-- <a href="{{url('lottery/'.$data->id.'/edit')}}" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
												  
												  <button type="submit" id="{{$data->id}}" class="btn btn-sm btn-danger delete_product" data-toggle="tooltip" title="Delete" ><i class="fa fa-trash" aria-hidden="true"></i></button>-->
												</td>
											</tr>
											 </form> 
										 <?php $i++; ?>
														@endforeach

										<?php 
										// echo count($data11);
										// echo "<pre>";
										// print_r($data11);
										?>

										</tbody>
										</table>
									</div>	
									

								
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
		</div>	
		<!-------------------Modal Start----------------->	
			  <div class="container"> 
                <!-- Trigger the modal with a button --> 
				<!-- Modal -->
				<div class="modal fade" id="view_modal" role="dialog">
					<div class="modal-dialog modal-lg">		
						<!-- Modal content-->
						<div class="modal-content">
						<div class="modal-header bg-success" style="color:#fff;">
						 <h4 class="modal-title"><i class="fas fa-info-circle"></i> Lottery Ticket Details</h4>
						 <button type="button" class="close" data-dismiss="modal">&times;</button>
					   
						</div>
						<div class="modal-body view_body" align="center">
						   
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>

						</div>
					</div>
				</div>
			  </div>
	<!-------------------Modal End----------------->
		
		<script>
		$(document).ready(function(){
			  $("#exampleValidation").validate({
			validClass: "success",
			rules: {
				name: {
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