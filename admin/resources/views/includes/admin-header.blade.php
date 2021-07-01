@php $url=url('public/images/loader.gif');@endphp
<style>
#loadingDiv{
  position:fixed;
  top:0px;
  right:0px;
  width:100%;
  height:100%;
  background-color:#666;
  background-image:url({{$url}});
  background-repeat:no-repeat;
  background-position:center;
  z-index:10000000;
  opacity: 0.4;
  filter: alpha(opacity=40); /* For IE8 and earlier */
}
</style>
<div id="loadingDiv" style="display:none;" >
    <div>
        <h7>Please wait...</h7>
    </div>
</div>
<div class="main-header">
			<!-- Logo Header -->
			<div class="logo-header" data-background-color="purple">
				
				<a href="{{url('dashboard')}}" class="logo">
					<img src="{{url('public/images/'.Auth::user()->user_image)}}" alt="..." class=" rounded-circle" style="width:43px;"> <span style="color: #fff;font-weight: bold;font-size: 23px;">{{env("APP_NAME")}}</span>
				</a>
				<button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon">
						<i class="icon-menu"></i>
					</span>
				</button>
				<button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
				<div class="nav-toggle">
					<button class="btn btn-toggle toggle-sidebar" style="margin-top: 18px;">
						<i class="icon-menu"></i>
					</button>
				</div>
			</div>
			<!-- End Logo Header -->

			<!-- Navbar Header -->
			<nav class="navbar navbar-header navbar-expand-lg" data-background-color="purple">
				
				<div class="container-fluid">
					<div class="collapse" id="search-nav">
						<!--<form class="navbar-left navbar-form nav-search mr-md-3">
							<div class="input-group">
								<div class="input-group-prepend">
									<button type="submit" class="btn btn-search pr-1">
										<i class="fa fa-search search-icon"></i>
									</button>
								</div>
								<input type="text" placeholder="Search ..." class="form-control">
							</div>
						</form>-->
					</div>
					<ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
						<li class="nav-item toggle-nav-search hidden-caret">
							<a class="nav-link" data-toggle="collapse" href="#search-nav" role="button" aria-expanded="false" aria-controls="search-nav">
								<i class="fa fa-search"></i>
							</a>
						</li>
						
						
						
						<li class="nav-item dropdown hidden-caret">
							<a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
								<div class="avatar-sm">
									<img src="{{url('public/images/'.Auth::user()->user_image)}}" alt="..." class="avatar-img rounded-circle">
								</div>
							</a>
							<ul class="dropdown-menu dropdown-user animated fadeIn">
								<div class="dropdown-user-scroll scrollbar-outer">
									<li>
										<div class="user-box">
											<div class="avatar-lg"><img src="{{url('public/images/'.Auth::user()->user_image)}}" alt="image profile" class="avatar-img rounded"></div>
											<div class="u-text">
												<h4>{{Auth::user()->name}}</h4>
												<p class="text-muted">{{Auth::user()->email}}</p>
												<a href="{{url('profile')}}" class="btn btn-xs btn-secondary btn-sm">View Profile</a>
												
											</div>
										</div>
									</li>
									<li>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item" href="{{url('profile')}}">My Profile</a>
										
										<div class="dropdown-divider"></div>
										<a href="{{url('changepassword')}}" class="dropdown-item">Change Password</a>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item" href="{{url('logout')}}">Logout</a>
									</li>
								</div>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
			<!-- End Navbar -->
		</div>