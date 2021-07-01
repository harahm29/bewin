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
                                <h3>Add Money</h3>
                            </div>
                            <ul>
                                <li class="home-bread">Home</li>
                                <li>Add Money</li>
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
					   <h3 class="mgbt-md-15 mgtp-10 font-semibold" ><i class="icon-user-md"></i>   <span data-toggle="tooltip" title="Please Click On Edit Profile For Edit Your Personal Information"><a href="#" id="edit"><u>Add Money </u></a></span></h3> 
					  <form id="exampleValidation" action="{{url('user-money')}}" method="post">
				   @csrf
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Token</label>
                          <input type="text" class="form-control" name="voucher" id="voucher">
						    <div class="text-danger error">{{$errors->first('voucher')}}</div>
                        </div>
                      </div>
                    </div>
                    <!--<div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Amount</label>
                          <input type="text" class="form-control numeric_feild" name="amount" id="amount">
						  <div class="text-danger error">{{$errors->first('amount')}}</div>
                        </div>
                      </div>
					 
                    </div>-->
                 
					<div class="row">
					
                     
                    </div>
                   
                    <button style="width:178px;" type="submit"  class="slide-btn login-btn">Submit</button>
                    
                    <div class="clearfix"></div>
                  </form>
			  </div>       
                    </div>
                </div>
            </div>
        </div>
		
	<input type="hidden" name="user_id" id="user_id" value="@if(Auth::check()){{Auth::user()->id}}@else 0 @endif" />
	
        <!-- End Number area -->	
		
		<!-- jquery latest version -->
		<script src="{{url('public/frontend/js/vendor/jquery-1.12.4.min.js')}}"></script>
		  <script>
            $(function() {
 
 $("#dob").datepicker({ 
       autoclose: true, 
       todayHighlight: true
 }).datepicker('update', new Date());
});
		$(document).ready(function(){
            
			  $("#exampleValidation").validate({
			validClass: "success",
			rules: {
				name: {
					required: true
				},
				
				
                dob: {
					required: true
				},
                address: {
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