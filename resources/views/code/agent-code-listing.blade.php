@extends('layouts.admin')
@section('title','Agent Code Listing')
@section('content')
<style>
.error{
	color:red;
}
</style>
 <!-- Start Bottom Header -->
 <div class="page-area">
            <div class="breadcumb-overlay"></div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="breadcrumb text-center">
                            <div class="section-headline text-center">
                                <h3>Agent Code</h3>
                            </div>
                            <ul>
                                <li class="home-bread">Home</li>
                                <li> Code Purchase Details</li>
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
					
				</div>
                 <div class="row">
                    <div class="lottery-content">
                    <div class="row">
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
        
              
					</div>  
                     <div  align="right"><h3 style="float:left;" class="mgbt-md-15 mgtp-10 font-semibold" >Code Purchase - Details</h3>
									<a  align="right" href="{{url('agent-history')}}" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Back" ><b><i class="fas fa-backspace" aria-hidden="true"></i> Back</b></a>

					 </div>   
					<br>
					<div class="deposite-content">
                            <div class="diposite-box">
                                <div class="deposite-table">
                                    <table>
                                       <thead>
										<tr>
										<th>Sr No.</th>
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

										<?php $order_stats_txt_new = "<span style='float:left;padding:1px 9px;font-size:16px;background:#ffad46!important;' class='text-warning'><i class='fa fa-clock-o' aria-hidden='true'></i> Pending</span>"; ?>

										@elseif($code->status==2)

										<?php $order_stats_txt_new = '<span style="float:left;padding:1px 13px;font-size:16px;background:#337ab7;" class="text-primary"><i class="fa fa-check" aria-hidden="true"></i> Used</span>'; ?>
										
										@elseif($code->status==3)

										<?php $order_stats_txt_new = '<span style="float:left;padding:1px 9px;font-size:16px;background:red;" class="text-danger"><i class="fa fa-times" aria-hidden="true"></i> Expired</span>'; ?>

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
							 {{ $codes->appends(request()->query())->links() }}
                        </div>
                      

                    </div>
                </div>
            </div>
        </div>
		
	

	
        <!-- End Number area -->	
		
		<!-- jquery latest version -->
		<script src="{{url('public/frontend/js/vendor/jquery-1.12.4.min.js')}}"></script>
		<script>
		function submit()
		{
			$("form").submit();
		}
		
		$(document).ready(function(){
			
			
			  $("#exampleValidation").validate({
			validClass: "success",
			rules: {
				"voucher_no[]": {
					required: true
				},
					
			},
			messages: { 
            "voucher_no[]": "Please select at least 1 code."
			},
			highlight: function(element) {
				$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
			},
			success: function(element) {
				$(element).closest('.form-group').removeClass('has-error').addClass('has-success');
			},
		});
			
		})
		</script>
		
@endsection	