@extends('layouts.admin')
@section('title','Admin | changepassword')
@section('content')

	<div class="main-panel">
			<div class="content">
				<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Change Password</h4>
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
								<a href="{{url('dashboard')}}">Change Password</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="#">Change Passwqord</a>
							</li>
						</ul>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									
								</div>
								<form method="post" action="{{url('change-password')}}" id="exampleValidation">
								@csrf
									<div class="card-body">
										<div class="form-group form-show-validation row">
											<label for="new_password" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">New Password <span class="required-label">*</span></label>
											<div class="col-lg-4 col-md-9 col-sm-8">
												<input type="password" class="form-control" id="new_password" name="new_password" placeholder="Enter new password" >
											</div>
										</div>
										<div class="form-group form-show-validation row">
											<label for="confirm_password" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">Confirm Password <span class="required-label">*</span></label>
											<div class="col-lg-4 col-md-9 col-sm-8">
												<div class="input-group">
													<div class="input-group-prepend">
														
													</div>
													<input type="password" class="form-control" placeholder="Enter confirm password" aria-label="confirm password" aria-describedby="weight-addon" id="confirm_password" name="confirm_password" >
												</div>
											</div>
										</div>
									
										
										
									
										
										
										
										
										
										
									</div>
									<div class="card-action">
										<div class="row">
											<div class="col-md-12">
												<input class="btn btn-success" type="submit" value="Submit" id="submit">
												<button class="btn btn-danger">Cancel</button>
											</div>										
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			
		</div>

       
 <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

</script>

    
		<script>
		$(document).ready(function(){
			/* validate */

		// validation when select change
		$("#state").change(function(){
			$(this).valid();
		})

		// validation when inputfile change
		$("#uploadImg").on("change", function(){
			$(this).parent('form').validate();
		})

			$("#exampleValidation").validate({
			validClass: "success",
			rules: {
			new_password: {required: true,
			 minlength: 5,
			},
			
			
			
			confirm_password: {required: true,
			 equalTo: "#new_password",
			  minlength: 5,
			},
        

			
			
			
			},
			highlight: function(element) {
				$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
			},
			success: function(element) {
				$(element).closest('.form-group').removeClass('has-error').addClass('has-success');
			},
		});
		});

		

		
		
		
	</script>
		
@endsection	