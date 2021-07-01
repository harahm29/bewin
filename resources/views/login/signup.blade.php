<!-- head area -->
@include('includes.admin-head')
<style>
.error{
    color:red;
}

</style>
		<!-- end  head area -->
		<body data-spy="scroll" data-target="#navbar-example">

		<!--[if lt IE 8]>
			<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
		<![endif]-->
		

        <!-- Start Slider Area -->
        <div class="login-area area-padding fix">
            <div class="login-overlay"></div>
            <div class="table">
                <div class="table-cell">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8 col-xs-12">
                                <div class="login-form signup-form">
                                    <h4 class="login-title text-center">REGISTER</h4>
                                    <div class="row">
									@if(session('message'))
										<p class="alert alert-success">{{session('message')}}</p>
									@endif
									@if(session('login_message'))
										<p class="alert alert-danger">{{session('login_message')}}</p>
									@endif
                                        <form id="exampleValidation" method="POST" action="{{url('signup')}}" class="log-form" novalidate>
                                        @csrf  
										@if(isset($referrer))
										<input type="hidden" name="referrer" value="{{$referrer}}" />
										@endif
											<div class="col-md-12 col-sm-12 col-xs-12">
                                                 <label class="radio-inline" style="color:#000;font-size;15px;">I am </label>
												 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												 <label class="radio-inline">
												  <input type="radio" name="type" value="user" checked>User
												</label>
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												<label class="radio-inline">
												  <input type="radio" name="type" value="agent">Agent
												</label>
                                                <div class="text-danger error">{{$errors->first('type')}}</div><br>
                                            </div>
											<div class="col-md-6 col-sm-6 col-xs-6">
                                                <input type="text" id="first_name" name="first_name" class="form-control" value="{{old('first_name')}}" placeholder="First Name"  >
                                                <div class="text-danger error">{{$errors->first('first_name')}}</div>
                                            </div>
											<div class="col-md-6 col-sm-6 col-xs-6">
                                                <input type="text" id="last_name" name="last_name" class="form-control" value="{{old('last_name')}}" placeholder="Last Name"  >
                                                <div class="text-danger error">{{$errors->first('last_name')}}</div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <input type="text" id="dob" name="dob" class="form-control" value="{{old('dob')}}" placeholder="Date of birth" required >
                                                <div class="text-danger error">{{$errors->first('dob')}}</div>
                                            </div>
											 <div class="col-md-6 col-sm-6 col-xs-6">
                                                <input type="email" id="email" name="email" value="{{old('email')}}" class="form-control" placeholder="Your Email" required >
                                                <div class="text-danger error">{{$errors->first('email')}}</div>
                                            
                                            </div>
											 <div class="col-md-6 col-sm-6 col-xs-6">
                                                <input type="password" id="password" name="password" value="{{old('password')}}" class="form-control" placeholder="Password" required >
                                                <div class="text-danger error">{{$errors->first('password')}}</div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <input type="password" id="confirmation_password" name="confirmation_password" class="form-control" placeholder="Confirm Password" required >
												 <div class="text-danger error">{{$errors->first('confirmation_password')}}</div>
                                            </div>
                                            
											<div class="col-md-12 col-sm-12 col-xs-12">
                                                <textarea type="text" id="address" name="address" value="{{old('address')}}" class="form-control" placeholder="Address" required >{{old('address')}}</textarea>
                                                <div class="text-danger error">{{$errors->first('address')}}</div>
                                            
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <input type="text" id="mobile_no" name="mobile_no" value="{{old('mobile_no')}}" class="form-control numeric_feild" placeholder="Mobile No" required >
                                                <div class="text-danger error">{{$errors->first('mobile_no')}}</div>
                                            </div>
											<div class="col-md-6 col-sm-6 col-xs-6">
                                                <input type="text" id="city" name="city" value="{{old('city')}}" class="form-control" placeholder="City" required >
                                                <div class="text-danger error">{{$errors->first('city')}}</div>
                                            </div>
											<div class="col-md-6 col-sm-6 col-xs-6">
                                                <input type="text" id="province" name="province" value="{{old('province')}}" class="form-control" placeholder="Province" required >
                                                <div class="text-danger error">{{$errors->first('province')}}</div>
                                            </div>
											<div class="col-md-6 col-sm-6 col-xs-6">
                                                <input type="text" id="postal_code" name="postal_code" value="{{old('postal_code')}}" maxlength="10" class="form-control" placeholder="Postal Code" required >
                                                <div class="text-danger error">{{$errors->first('postal_code')}}</div>
                                            </div>
                                           <div class="col-md-6 col-sm-6 col-xs-6">
                                                <select type="text" id="document_type" name="document_type" value="{{old('document_type')}}" class="form-control" placeholder="Document Type"  > 
												<option value="">Select Document Type</option>
												<option {{old('document_type')=="driving_licence"?"selected":""}} value="driving_licence">Driving Licence</option>
												<option {{old('document_type')=="national_id"?"selected":""}} value="national_id">National id</option>
												</select>
												
                                                <div class="text-danger error">{{$errors->first('document_id')}}</div>
                                            </div>
											<div class="col-md-6 col-sm-6 col-xs-6">
                                                <input type="text" id="document_id" name="document_id" value="{{old('document_id')}}" class="form-control" placeholder="Document Id"  >
                                                <div class="text-danger error">{{$errors->first('document_id')}}</div>
                                            </div>
                                           
                                            
                                            <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                                                <div class="check-group flexbox">
                                                    <label class="check-box">
                                                        <input type="checkbox" name="tac" id="tac" class="check-box-input" value="1" checked>
                                                        <span class="remember-text">I agree terms & conditions</span>
                                                    </label>
													 <div class="text-danger error">{{$errors->first('tac')}}</div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                                                <button type="submit" id="submit1" class="slide-btn login-btn">Signup</button>
                                                <div id="msgSubmit" class="h3 text-center hidden"></div> 
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                                                <div class="clear"></div>
                                                <!-- <div class="separetor text-center"><span>Or with signup</span></div> -->
                                                <div class="sign-icon">
                                                  <!--  <ul>
                                                        <li><a class="facebook" href="#"><i class="fa fa-facebook-square"></i>Facebook</a></li>
                                                        <li><a class="twitter" href="#"><i class="fa fa-twitter-square"></i>twitter</a></li>
                                                        <li><a class="google" href="#"><i class="fa fa-google-plus-square"></i>google</a></li>
                                                    </ul>-->
                                                    <div class="acc-not">have an account?  <a href="{{url('signin')}}">Login</a></div>
                                                </div>
                                            </div>
                                        </form> 
                                    </div>
                                </div>
                            </div>
                        </div>
                     </div>
                </div>
            </div>
        </div>
        <!-- End Slider Area -->
		
		<!-- all js here -->

		<!-- jquery latest version -->
		<script src="{{url('public/frontend/js/vendor/jquery-1.12.4.min.js')}}"></script>
		<!-- bootstrap js -->
		<script src="{{url('public/frontend/js/bootstrap.min.js')}}"></script>
		<!-- Form validator js -->
		<script src="{{url('public/frontend/js/form-validator.min.js')}}"></script>
		<!-- plugins js -->
        <script src="{{url('public/frontend/js/plugins.js')}}"></script>
        <script src="{{url('public/assets/js/plugin/jquery.validate/jquery.validate.min.js')}}"></script>
        <!--Datepickr-->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script> 
        <script>
            $(function() {
 
 $("#dob").datepicker({ 
       autoclose: true, 
       todayHighlight: true
 });
});
		$(document).ready(function(){
            
			  $("#exampleValidation1").validate({
			validClass: "success",
			rules: {
				first_name: {
					required: true
				},
				last_name: {
					required: true
				},
				email: {
					required: true
				},
				password: {
					required: true,
				},
                confirmation_password: {
					required: true,
                    equalTo:"#password"
				},
                dob: {
					required: true
				},
                address: {
					required: true
				},
				city: {
					required: true
				},
				province: {
					required: true
				},
				postal_code: {
					required: true
				},
				mobile_no: {
					required: true,
					number:true
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
	</body>
</html>
