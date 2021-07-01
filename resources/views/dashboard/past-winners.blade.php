@extends('layouts.admin')
@section('title','Past Winners')
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
                                <h3>Past Winning Numbers</h3>
                            </div>
                            <ul>
                                <li class="home-bread">Home</li>
                                <li>Past Winning Numbers</li>
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
				<div  align="right"><h3 style="float:left;" class="mgbt-md-15 mgtp-10 font-semibold" ></h3>
		</div> 
				  <form class="form-horizontal" method="get" action="{{url()->current()}}">
                    <div class="col-md-12">
                      <div class="form-group form-show-validation row">
                      
                       <div class="col-lg-3">
							 
					
								<select id="name" class="form-control dd" name="lottery_id"  >

								<option value="">-Select Lottery-</option>
								@foreach($lotterys as $lottery_val)
								<option value="{{$lottery_val->id}}" {{$lottery_val->id == $lottery_id ? 'selected':''}}>{{$lottery_val->name}}</option>
								@endforeach
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
                 <div class="row">
                    <div class="lottery-content">
                       
                       <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="deposite-content">
                            <div class="diposite-box">
                                <div class="deposite-table">
                                   <table>
                                        <tr>
                                           
                                          
											<th>Lottery name</th>
											<th>Draw Date</th>
                                            <th>Winning Numbers</th>
                                            <th>Winning Price</th> 
                                        </tr>
                                        @foreach($winners as $winner)
										<tr>
                                           
                                            
											<td><img src="{{url('admin/public/images/'.$winner->lottery_image)}}" alt=""  style="max-width:30px;" >{{$winner->lottery_name}}</td>
											<td>{{date("d-m-Y",strtotime($winner->today_date))}}</td>
                                            <td>
											@php $lottery_array = explode(",",$winner->lottery_draw_no); @endphp
                                               <ul class="self-number">
											   @foreach($lottery_array as $lottery)
                                                    <li><a href="#">{{$lottery}}</a></li>
											   @endforeach
											    <li><a href="#" style="background:blue;">{{$winner->lottery_draw_power_ball}}</a></li>
                                                </ul>
                                            </td>
                                            <td>@if(is_numeric($winner->lottery_amount))$@else @endif {{$winner->lottery_amount}}</td>
                                           
                                        </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
					{{ $winners->appends(request()->query())->links() }}
                   
                      

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
			
			// $(".submit_btn").click(function(e){
				
				// grand_total_val = parseFloat($(".grand_total").val());
				// if(isNaN(grand_total_val))
				// grand_total_val = 0;
				
				// if(grand_total_val < 1)
				// {
					// e.preventDefault();
					// console.log("grand_total_val >> "+grand_total_val);
				  // bootbox.alert("Please select at least 1 code");
				// }
				// else{
					// return true;
				// }
			// })
			  $("#exampleValidation").validate({
			validClass: "success",
			rules: {
				code: {
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
			$(".code").on("keyup change",function(){
				
				var code = ($(this).val());
				$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
				});
				$.ajax({
					url:"{{url('check-code')}}",
					type:"post",
					data:{code:code},
					dataType:"json",
					success:function(data)
					{
						console.log(JSON.stringify(data));

						if(data.status==1)
						{
							$("#value").text(data.value);
							$("#status").html("<span class='text-success'>Available<span>");
							$("#code_valid").val("$"+data.value);
							$(".submit_btn").prop("disabled",false);
							$(".error").text("");
						}
						if(data.status==2)
						{
							$("#value").text(data.value);
							$("#status").html("<span class='text-primary'>Used</span>");
							$("#code_valid").val("$"+data.value);
						}
						if(data.status==3)
						{
							$("#value").text(data.value);
							$("#status").html("<span class='text-danger'>Expired</span>");
							$("#code_valid").val("$"+data.value);
						}
						if(data.status==0)
						{
							$("#value").text(data.value);
							$("#status").html("<span class='text-danger'>Invalid</span>");
							$("#code_valid").val("$"+data.value);
						}
					}
					
				})
			});
			
			$(".reset").click(function(){
				href = $(this).attr('href');
				location.href = href;
				
			})
		})
		</script>
		
@endsection	