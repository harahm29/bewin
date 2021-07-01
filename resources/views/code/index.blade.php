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
                                <h3>Agent Code Listing</h3>
                            </div>
                            <ul>
                                <li class="home-bread">Home</li>
                                <li>Agent Code Listing</li>
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
                      
                       <div class="col-lg-3">
							
					
								<select id="status" class="form-control" name="status"  placeholder="Enter Teacher Name" onchange="submit()" >

								<option value="">-Select-</option>
								<option value="1" {{$status==1?"selected":""}}>Active</option>
								<option value="2" {{$status==2?"selected":""}}>Used</option>
								<option value="3" {{$status==3?"selected":""}}>Expired</option>
								
								</select>
						</div>
						
							
						
						<div class="col-lg-1">
						  <button type="submit" class="btn btn-success"><i class="fas fa-search" aria-hidden="true"></i> Search</button>
						 </div>
						 <div class="col-lg-2">
						<a href="{{url()->current()}}">
					 <button type="button" class="btn btn-info"><i class="fas fa-sync-alt"></i> Reset</button> </a>
						 </div>
					&nbsp;
                     
					   </div>
					   
                      
              </div>
             </form>
        
              
         </div>  
                       
					
					<div class="deposite-content">
                            <div class="diposite-box">
                                <div class="deposite-table">
                                    <table>
                                        <tr>
                                            <th>SrNo.</th>
										    <th>Code</th>
										    <th>Value</th>
										    <th>Date Creation</th> 
										    <th>Date Expire</th> 
										    <th>Status</th> 
                                        </tr>
                                        <?php $i=1;?>
										@foreach($codes as $code)
										@if($code->status==1)

										<?php $order_stats_txt_new = "<span style='float:left;padding:1px 9px;font-size:16px;'  class='text-success'><i class='fa fa-check' aria-hidden='true'></i> Active</span>";
										 ?>
										@elseif($code->status==0)

										<?php $order_stats_txt_new = "<span style='float:left;padding:1px 9px;font-size:16px;' class='text-warning'><i class='fa fa-clock-o' aria-hidden='true'></i> Pending</span>"; ?>

										@elseif($code->status==2)

										<?php $order_stats_txt_new = '<span style="float:left;padding:1px 13px;font-size:16px;background:#269abc;" class="text-primary"><i class="fa fa-check" aria-hidden="true"></i> Used</span>'; ?>
										
										@elseif($code->status==3)

										<?php $order_stats_txt_new = '<span style="float:left;padding:1px 9px;font-size:16px;background:#d9534f;" class="text-danger"><i class="fa fa-times" aria-hidden="true"></i> Expired</span>'; ?>

										@endif       
										
										<tr>
													<td>{{$i}}</td>
													<td>{{$code->code}}</td>
													<td>${{$code->value}}</td>
													<td>{{date("d-M-Y",strtotime($code->today_date))}}</td>
													<td>{{date("d-M-Y",strtotime($code->expire_date))}}</td>
													<td><?php echo $order_stats_txt_new;?></td>
													
												</tr>
												@php $i++; @endphp
												@endforeach
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