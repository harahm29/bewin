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
                                <h3>Change Password </h3>
                            </div>
                            <ul>
                                <li class="home-bread">Home</li>
                                <li>Change Password </li>
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
                     
					  
					 
				  <form method="post" action="{{url('change-password')}}" id="exampleValidation">
								@csrf
									<div class="card-body">
										<div class="form-group form-show-validation row">
											<label for="new_password" class="col-lg-2 col-md-2 col-sm-4 mt-sm-2 ">New Password <span class="required-label">*</span></label>
											<div class="col-lg-4 col-md-9 col-sm-8">
												<input type="password" class="form-control" id="new_password" name="new_password" placeholder="Enter new password" >
											</div>
										</div>
										<div class="form-group form-show-validation row">
											<label for="confirm_password" class="col-lg-2 col-md-2 col-sm-4 mt-sm-2 ">Confirm Password <span class="required-label">*</span></label>
											<div class="col-lg-4 col-md-9 col-sm-8">
											<input type="password" class="form-control" placeholder="Enter confirm password" aria-label="confirm password" aria-describedby="weight-addon" id="confirm_password" name="confirm_password" >
											</div>
										</div>
									
										
										
									
										
										
										
										
										
										
									</div>
									<div class="card-action"> 
										<div class="row" >
											<div class="col-md-4" align="center" >
												<input align="center" class="btn btn-success" type="submit" value="Submit" id="submit">
												<button align="center"  class="btn btn-danger">Cancel</button>
											</div>										
										</div>
									</div>
								</form>
				  
				  
				  
		
      
					  
                      
	
                       
                        
                    </div>
                </div>
            </div>
        </div>
		
	<input type="hidden" name="user_id" id="user_id" value="@if(Auth::check()){{Auth::user()->id}}@else 0 @endif" />
	
        <!-- End Number area -->	
		
		<!-- jquery latest version -->
		<script src="{{url('public/frontend/js/vendor/jquery-1.12.4.min.js')}}"></script>
		  <script>
          
		$(document).ready(function(){
            
			  $("#exampleValidation").validate({
			validClass: "success",
			rules: {
				new_password: {
					required: true
				},
                confirm_password: {
					required: true,
					equalTo:"#new_password"
				},
                
				
				
				
			},
			
			highlight: function(element) {
				$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
			},
			success: function(element) {
				$(element).closest('.form-group').removeClass('has-error').addClass('has-success');
			},
		});
		
	// For quantity validation
	 $(".numeric_feild").on("focus",function(event)
	 {
		id=$(this).attr('id');
		var text = document.getElementById(id);
		text.onkeypress = text.onpaste = checkInput;
	 });
	function checkInput(e) 
	{
	var e = e || event;
	var char = e.type == 'keypress' 
	? String.fromCharCode(e.keyCode || e.which) 
	: (e.clipboardData || window.clipboardData).getData('Text');
	if (/[^\d]/gi.test(char)) {
	return false;
	}
	}
	
	
   
		});

	</script>
		<script>
		function submit()
		{
			$("form").submit();
		}
		
		
		$(document).ready(function(){
			$("#edit").click(function(e){
				e.preventDefault();
				$("#first_name").prop("readonly",false);
				$("#last_name").prop("readonly",false);
				$("#dob").prop("disabled",false);
				$("#mobile_no").prop("readonly",false);
				$("#document_type").prop("disabled",false);
				$("#document_id").prop("readonly",false);
				$("#city").prop("readonly",false);
				$("#postal_code").prop("readonly",false);
				$("#province").prop("readonly",false);
				$("#address").prop("readonly",false);
				$(".login-btn").show();
			});
			

		})
		</script>
		
@endsection	