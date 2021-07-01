@extends('layouts.admin')
@section('title','Code Purchase')
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
                                <h3>User Code Purchase</h3>
                            </div>
                            <ul>
                                <li class="home-bread">Home</li>
                                <li>User Code Purchase</li>
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
                       
                       
		<div class="table-responsive">
		 <form id="exampleValidation" action="{{url('code-purchase')}}" method="post" enctype="multipart/form-data" novalidate>
			@csrf
			<table id="firsttab" class="table table-bordered table-striped" style="width:50%;" align="center">
                <thead bgcolor="#A9A9A9">
                <tr>
                  <th>Code</th>
                  <th>Value</th>
                  <th>Status</th>
                </tr>
                </thead>
                <tbody>
				 
		   
              <tr>
				<td> <input style="width:150px;"  type="text"  class="form-control code" name="code" id="code" value="{{old('code')}}"   />
				<span class="error">Please Enter valid code to redeem value</span>
				</td>
				<td id="value"></td>
				<td id="status"></td>
					
				
			  </tr>
			 
				
                
                </tbody>
				
            </table>
			<div class="col-md-12">			
			<div class="col-md-4">	
			</div>			
			<button style="width:178px;" align="center" type="submit"  class="slide-btn login-btn submit_btn" disabled >Make Payment</button>			
			<button style="width:178px;background:red;" href="{{url()->current()}}" align="center" type="reset"  class="slide-btn login-btn reset">Cancel</button>			
			</div>
				<input type="hidden" name="code_valid" id="code_valid" value="" />
			</form>						
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