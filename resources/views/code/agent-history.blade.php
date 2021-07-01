@extends('layouts.admin')
@section('title','Lottery')
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
                                <h3>Agent Code </h3>
                            </div>
                            <ul>
                                <li class="home-bread">Home</li>
                                <li> Code Purchase</li>
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
                    
                       
					
					
					
									<div  align="right"><h3 style="float:left;" class="mgbt-md-15 mgtp-10 font-semibold" >Previous - Code Purchase Details</h3>
									<a  align="right" href="{{url('code-purchase')}}" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Back" ><b><i class="fas fa-backspace" aria-hidden="true"></i> Back</b></a>

									</div> 
								<br>
					<div class="deposite-content">
                            <div class="diposite-box">
                                <div class="deposite-table">
                                    <table>
                                      <thead>
										<tr>
										<th>Sr No.</th>
										<th>Date</th>
										<th>Plan</th>
										<th>Total no. of Codes</th>
										<th>Total Value</th>
										<th>Action</th>
										</tr>
										</thead>

										<tbody>
										
										@php $i=1; 
										function get_voucher_names($id,$today_date)
										{
											$plan_names =  DB::table("codes")->select(DB::raw("vs.name as voucher_name"))
														->leftjoin("vouchers as vs",function($join){
															$join->on("vs.id","=","codes.voucher_id");
														})
														->where(['codes.is_deleted'=>0,'codes.user_id'=>$id,'codes.today_date'=>$today_date])
														->groupBy('vs.name')
														->pluck('voucher_name')->toarray();
											return $plan_name = implode(",",$plan_names);
										}
										@endphp
											@foreach($codes as $code)
											
											<tr>
												   <td>{{$i}}</td>
												   <td>{{date("d-M-Y",strtotime($code->today_date))}}</td>
												   <td >{{get_voucher_names($code->user_id,$code->today_date)}}</td>
												   <td >{{$code->total_code}}</td>
												   <td >{{$code->total_value}}</td>
												   <td> 
												    <a type="button" id="{{$code->id}}" href="{{url('agent-code-listing/'.$code->today_date)}}"  class="btn btn-sm btn-info"data-toggle="tooltip" title="View">	<i class="fa fa-eye" aria-hidden="true"></i></a>  
												   </td>
											</tr>
											 
										 @php $i++; @endphp
											@endforeach


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