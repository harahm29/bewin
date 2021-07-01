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
                                <h3>Personal Info</h3>
                            </div>
                            <ul>
                                <li class="home-bread">Home</li>
                                <li>Personal Info</li>
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
					   <h3 class="mgbt-md-15 mgtp-10 font-semibold" ><i class="icon-user-md"></i>   <span data-toggle="tooltip" title="Please Click On Edit Profile For Edit Your Personal Information"><a href="#" id="edit"><u>Edit Profile </u></a></span></h3> 
					  <form id="exampleValidation" action="{{url('update-profile')}}" method="post" enctype="multipart/form-data">
				   @csrf
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Email address</label>
                          <input type="email" class="form-control" name="email" id="email" value="{{Auth::user()->email}}" disabled>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">First Name</label>
                          <input type="text" class="form-control" name="first_name" id="first_name" value="{{Auth::user()->first_name}}" readonly>
						  <div class="text-danger error">{{$errors->first('first_name')}}</div>
                        </div>
                      </div>
					  <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Last Name</label>
                          <input type="text" class="form-control" name="last_name" id="last_name" value="{{Auth::user()->last_name}}" readonly>
						  <div class="text-danger error">{{$errors->first('last_name')}}</div>
                        </div>
                      </div>
                     
                    </div>
                    
                    <div class="row">
					 <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Date of birth</label>
                          <input type="text" class="form-control" name="dob" id="dob" value="{{date('m/d/Y',strtotime(Auth::user()->dob))}}" disabled>
						  <div class="text-danger error">{{$errors->first('dob')}}</div>
                        </div>
                      </div>
					<div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Mobile No</label>
                          <input type="text" class="form-control numeric_feild" name="mobile_no" id="mobile_no" value="{{Auth::user()->mobile_no}}" readonly >
						   <div class="text-danger error">{{$errors->first('mobile_no')}}</div>
                        </div>
                      </div>
					 
					 
					 
                    </div> 
					<div class="row">
					<div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Document Type</label>
                          <select type="text" class="form-control" name="document_type" id="document_type" value="{{Auth::user()->document_type}}" disabled>
						  <option value="">-Select-</option>
						  <option {{Auth::user()->document_type=="driving_licence"?"selected":""}} value="driving_licence">Driving Licence</option>
						  <option {{Auth::user()->document_type=="national_id"?"selected":""}} value="national_id">National id</option>
						  </select>
						  
						  <div class="text-danger error">{{$errors->first('document_id')}}</div>
                        </div>
                      </div>
					 <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Document Id</label>
                          <input type="text" class="form-control" name="document_id" id="document_id" value="{{Auth::user()->document_id}}" readonly>
						  <div class="text-danger error">{{$errors->first('document_id')}}</div>
                        </div>
                      </div>
					  
					</div>
					<div class="row">
					<div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">City</label>
                          <input type="text" class="form-control" name="city" id="city" value="{{Auth::user()->city}}" readonly>
						   <div class="text-danger error">{{$errors->first('city')}}</div>
                        </div>
                      </div>
					 <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Postal Code</label>
                          <input type="text" class="form-control" name="postal_code" id="postal_code" value="{{Auth::user()->postal_code}}" readonly>
						   <div class="text-danger error">{{$errors->first('postal_code')}}</div>
                        </div>
                      </div>
                      
					</div>
					<div class="row">
					 
					  <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Province</label>
                          <input type="text" class="form-control" name="province" id="province" value="{{Auth::user()->province}}" readonly>
						   <div class="text-danger error">{{$errors->first('province')}}</div>
                        </div>
                      </div>
					   <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Address</label>
                          <textarea type="text" id="address" name="address" value="{{old('address')}}" class="form-control" placeholder="Address" readonly data-error="Please enter your name">{{Auth::user()->address}}</textarea>
                           <div class="text-danger error">{{$errors->first('address')}}</div>
                        </div>
                      </div>
					</div>
					<div class="row">
					
                     
                    </div>
                   
                    <button style="width:178px;display:none;" type="submit"  class="slide-btn login-btn">Update Profile</button>
                    
                    <div class="clearfix"></div>
                  </form>
				  
				  
				  
				  
				  
   
     <!--
 
        <h3 class="mgbt-md-15 mgtp-10 font-semibold"><i class="icon-user-md"></i> ABOUT</h3>
        <div class="row">
          <div class="col-sm-6">
            <div class="row mgbt-md-0">
              <label class="col-md-5 control-label">First Name:</label>
              <div class="col-md-7 controls">{{Auth::user()->first_name}}</div>
              
            </div>
          </div> 
		  <div class="col-sm-6">
            <div class="row mgbt-md-0">
              <label class="col-md-5 control-label">Last Name:</label>
              <div class="col-md-7 controls">{{Auth::user()->last_name}}</div>
            
            </div>
          </div>
          <div class="col-sm-6">
            <div class="row mgbt-md-0">
              <label class="col-md-5 control-label">Dob:</label>
              <div class="col-md-7 controls">{{date("d-M-Y",strtotime(Auth::user()->dob))}}</div>
            
            </div>
          </div>
          
          <div class="col-sm-6">
            <div class="row mgbt-md-0">
              <label class="col-md-5 control-label">Email:</label>
              <div class="col-md-7 controls">{{Auth::user()->email}}</div>
           
            </div>
          </div>
           
		  
          
		  <div class="col-sm-6">
            <div class="row mgbt-md-0">
              <label class="col-md-5 control-label">Document Type:</label>
              <div class="col-md-7 controls">{{ucfirst(str_replace("_"," ",Auth::user()->document_type))}}</div>
             
            </div>
          </div> 
		  <div class="col-sm-6">
            <div class="row mgbt-md-0">
              <label class="col-md-5 control-label">Document Id:</label>
              <div class="col-md-7 controls">{{Auth::user()->document_id}}</div>
             
            </div>
          </div>
          
          <div class="col-sm-6">
            <div class="row mgbt-md-0">
              <label class="col-md-5 control-label">City:</label>
              <div class="col-md-7 controls">{{Auth::user()->city}}</div>
            
            </div>
          </div>
		  <div class="col-sm-6">
            <div class="row mgbt-md-0">
              <label class="col-md-5 control-label">Postal Code:</label>
              <div class="col-md-7 controls">{{Auth::user()->postal_code}}</div>
             
            </div>
          </div>
		  <div class="col-sm-6">
            <div class="row mgbt-md-0">
              <label class="col-md-5 control-label">Province:</label>
              <div class="col-md-7 controls">{{Auth::user()->province}}</div>
             
            </div>
          </div>
		  <div class="col-sm-6">
            <div class="row mgbt-md-0">
              <label class="col-md-5 control-label">Address:</label>
              <div class="col-md-7 controls">{{Auth::user()->address}}</div>
             
            </div>
          </div>
          <div class="col-sm-6">
            <div class="row mgbt-md-0">
              <label class="col-md-5 control-label">Website:</label>
              <div class="col-md-7 controls"><a href="{{url('/')}}">{{url('/')}}</a></div>
            
            </div>
          </div>
          <div class="col-sm-6">
            <div class="row mgbt-md-0">
              <label class="col-md-5 control-label">Phone:</label>
              <div class="col-md-7 controls">{{Auth::user()->mobile_no}}</div>
            
            </div>
          </div>
        </div>
        -->
       
        <!-- row --> 
      
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