@extends('layouts.admin')
@section('title',"Agent Code Listing")
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
						<h4 class="page-title">Agent Code Listing</h4>
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
								<a href="{{url('users')}}">Agent Code Listing</a>
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
									<a  align="right" href="{{url('agent-history/'.$user->id)}}" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Back" ><b><i class="fa fa-backspace" aria-hidden="true"></i> Back</b></a>

									</div> 
								</div>
								<div class="card-body">
								
						  <form class="form-horizontal" method="get" action="{{url()->current()}}">
							<div class="col-md-12">
							  <div class="form-group form-show-validation row">
							  
							   <div class="col-lg-2">
										<select id="plan" class="form-control" name="plan"  onchange="submit()" >
										<option value="">Select Plan</option>
										@foreach($vouchers as $voucher)
										<option value="{{$voucher->id}}" {{$plan==$voucher->id?"selected":""}}>{{$voucher->name}}</option>
										@endforeach
										</select>
								</div>
								<div class="col-lg-2">
										<select id="status" class="form-control" name="amount"  id="amount"  onchange="submit()" >
										<option value="">Select Value</option>
										@foreach($vouchers as $voucher)
										<option value="{{$voucher->amount}}" {{$amount==$voucher->amount?"selected":""}}>${{$voucher->amount}}</option>
										@endforeach
										</select>
								</div>
								<div class="col-lg-2">
										<select id="status" class="form-control" name="status"  onchange="submit()" >
										<option value="">Select Status</option>
										<option value="1" {{$status_code==1?"selected":""}}>Active</option>
										<option value="2" {{$status_code==2?"selected":""}}>Used</option>
										<option value="3" {{$status_code==3?"selected":""}}>Expired</option>
										</select>
								</div>
								
								<div class="col-lg-1">
								  <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-search" aria-hidden="true"></i> Search</button>
								 </div>
								 <div class="col-lg-1">
								<a href="{{url()->current()}}">
								<button type="button" class="btn btn-info  btn-sm"><i class="fas fa-sync-alt"></i> Reset</button> </a>
								 </div>
							&nbsp;
							 
							   </div>
							   
							  
					  </div>
					 </form>
					
								@if(session('message'))
				<p class="alert alert-success">{{session('message')}}</p>
			@endif
									

									<div class="table-responsive">
										<table id="example1" class="display table table-striped table-hover"  >

										<thead>
										<tr>
										<th>SrNo</th>
										<th>Plan</th>
										<th>Code</th>
										<th>Value</th>
										<th>Date of Creation</th>
										<th>Date of Expire</th>
										<th>Status</th>
										</tr>
										</thead>

										<tbody>
										<tr>
										@php $i=1; @endphp
											@foreach($codes as $code)
											@if($code->status==1)

										<?php $order_stats_txt_new = "<span style='float:left;padding:1px 9px;font-size:16px;'  class='text-success'><i class='fa fa-check' aria-hidden='true'></i> Active</span>";
										 ?>
										@elseif($code->status==0)

										<?php $order_stats_txt_new = "<span style='float:left;padding:1px 9px;font-size:16px;' class='text-warning'><i class='fa fa-clock-o' aria-hidden='true'></i> Pending</span>"; ?>

										@elseif($code->status==2)

										<?php $order_stats_txt_new = '<span style="float:left;padding:1px 13px;font-size:16px;" class="text-primary"><i class="fa fa-check" aria-hidden="true"></i> Used</span>'; ?>
										
										@elseif($code->status==3)

										<?php $order_stats_txt_new = '<span style="float:left;padding:1px 9px;font-size:16px;" class="text-danger"><i class="fa fa-times" aria-hidden="true"></i> Expired</span>'; ?>

										@endif       
											
												   <td>{{$i}}</td>
												   <td >{{$code->voucher_name}}</td>
												   <td >{{$code->code}}</td>
												   <td >{{$code->value}}</td>
												   <td>{{date("d-M-Y",strtotime($code->today_date))}}</td>
												   <td>{{date("d-M-Y",strtotime($code->expire_date))}}</td>
												   <td><?= $order_stats_txt_new; ?></td>
												<!--<td> 
												   <form method="post" id="delete_form_{{$code->id}}" action="{{url('code/'.$code->id)}}"  style="width:150px;">
													@method('DELETE')
													@csrf
												<input type="hidden" name="id" id="id" value="{{$code->id}}" />
											
												<button type="button" id="{{$code->id}}" href="{{url('code/'.$code->id)}}"  class="btn btn-sm btn-info view"data-toggle="tooltip" title="View">	<i class="fa fa-eye" aria-hidden="true"></i></button>  
												
												 <a href="{{url('code/'.$code->id.'/edit')}}" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
												  
												  <button type="submit" id="{{$code->id}}" class="btn btn-sm btn-danger delete_product" data-toggle="tooltip" title="Delete" ><i class="fa fa-trash" aria-hidden="true"></i></button>
												</td>-->
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
						 <h4 class="modal-title"><i class="fas fa-info-circle"></i> Code Details</h4>
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
		
		});

	</script>
		
@endsection	