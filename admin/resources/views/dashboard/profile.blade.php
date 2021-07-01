@extends('layouts.admin')
@section('title','Product Plan')
@section('content')
		<div class="main-panel">
			<div class="content">
			<form class="form-horizontal" enctype="multipart/form-data" method="post" action="{{url('update-profile')}}" >
			@csrf
				<div class="page-inner">
					<h4 class="page-title">User Profile</h4>
					@if(session('message'))
				<p class="alert alert-success">{{session('message')}}</p>
			@endif
					<div class="row">
						<div class="col-md-8">
							<div class="card card-with-nav">
								<div class="card-header">
									<div class="row row-nav-line">
										<ul class="nav nav-tabs nav-line nav-color-secondary" role="tablist">
										
											<li class="nav-item"> <a class="nav-link active show" data-toggle="tab" href="#profile" role="tab" aria-selected="false">Profile</a> </li>
											
										</ul>
									</div>
								</div>
								<div class="card-body">
									<div class="row mt-3">
										<div class="col-md-6">
											<div class="form-group form-group-default">
												<label>Name</label>
												<input type="text" class="form-control" name="name" placeholder="Name" value="{{Auth::user()->name}}">
												<div class="text-danger">{{ $errors->first('name') }}</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group form-group-default">
												<label>Email</label>
												<input type="email" class="form-control" name="email" placeholder="Name" value="{{Auth::user()->email}}">
												<div class="text-danger">{{ $errors->first('email') }}</div>
											</div>
										</div>
									</div>
									<div class="row mt-3">
									<div class="col-md-4">
											<div class="form-group form-group-default">
												<label>Phone</label>
												<input type="text" class="form-control" value="{{Auth::user()->mobile_no}}" name="mobile_no" placeholder="Phone">
												<div class="text-danger">{{ $errors->first('mobile_no') }}</div>
											</div>
										</div>
									</div>
									
									<div class="row mt-3 mb-1">
										<div class="col-md-12">
											<div class="form-group form-group-default">
												<label>Profile Photo</label>
												<input type="file" class="form-control form-control-file" name="user_image" id="user_image" placeholder="Photo" >
												<div class="text-danger">{{ $errors->first('user_image') }}</div>
											</div>
										</div>
									</div>
									@if(Auth::user()->type=='teacher')
									<div class="row mt-3 mb-1">
										<div class="col-md-12">
											<div class="form-group form-group-default">
												<label>Referral</label>
												<input type="text" class="form-control form-control-file" name="referal" value="{{Auth::user()->referal}}" id="referal" placeholder="Referral" >
												<div class="text-danger">{{ $errors->first('referal') }}</div>
											</div>
										</div>
									</div>
									@endif
									<div class="text-right mt-3 mb-3">
										<button type="submit" class="btn btn-success">Save</button>
										<button type="reset" class="btn btn-danger">Reset</button>
									</div>
								</div>
							</div>
						</div>
					</form>	
						<div class="col-md-4">
							<div class="card card-profile">
								<div class="card-header" style="background-image: url({{url('public/images/blogpost.jpg')}})">
									<div class="profile-picture">
										<div class="avatar avatar-xl">
											<img src="{{url('public/images/'.Auth::user()->user_image)}}" alt="..." class="avatar-img rounded-circle" id="image_preview">
										</div>
									</div>
								</div>
								<div class="card-body">
									<div class="user-profile text-center">
										<div class="name">{{ucwords(Auth::user()->name)}}</div>
										<div class="job">{{ucwords(Auth::user()->email)}}</div>
										<div class="desc">{{ucwords(Auth::user()->area)}}</div>
										<div class="social-media">
											<a class="btn btn-info btn-twitter btn-sm btn-link" href="#"> 
												<span class="btn-label just-icon"><i class="flaticon-twitter"></i> </span>
											</a>
											<a class="btn btn-danger btn-sm btn-link" rel="publisher" href="#"> 
												<span class="btn-label just-icon"><i class="flaticon-google-plus"></i> </span> 
											</a>
											<a class="btn btn-primary btn-sm btn-link" rel="publisher" href="#"> 
												<span class="btn-label just-icon"><i class="flaticon-facebook"></i> </span> 
											</a>
											<a class="btn btn-danger btn-sm btn-link" rel="publisher" href="#"> 
												<span class="btn-label just-icon"><i class="flaticon-dribbble"></i> </span> 
											</a>
										</div>
										<div class="view-profile">
											<a href="#" class="btn btn-secondary btn-block">View Full Profile</a>
										</div>
									</div>
								</div>
								
							</div>
						</div>
					</div>
				</div>
			</div>
			
		</div>
		 <script>
  $(document).ready(function(){
	 function readURL(input) 
	{
		if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function(e) {
		$('#image_preview').attr('src', e.target.result);

		$('#image_preview').hide();
		$('#image_preview').fadeIn(650);
		}
	   reader.readAsDataURL(input.files[0]);
		}
	}

	$("#user_image").change(function() {
	readURL(this);
	}); 
  });
  </script>
@endsection			