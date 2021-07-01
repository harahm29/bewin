<!-- Sidebar -->   
		<div class="sidebar sidebar-style-2" data-background-color="dark2">
			<div class="sidebar-wrapper scrollbar scrollbar-inner">
				<div class="sidebar-content">
					<div class="user">
						<div class="avatar-sm float-left mr-2">
							<img src="{{url('public/images/'.Auth::user()->user_image)}}" alt="..." class="avatar-img rounded-circle">
						</div>
						<div class="info">
							<a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
								<span>
									{{Auth::user()->name}}
									<span class="user-level">Administrator</span>
									<span class="caret"></span>
								</span>
							</a>
							<div class="clearfix"></div>

							<div class="collapse in" id="collapseExample">
								<ul class="nav">
									<li>
										<a href="{{url('profile')}}">
											<span class="link-collapse">My Profile</span>
										</a>
									</li>
									<li>
										<a href="{{url('profile')}}>
											<span class="link-collapse">Edit Profile</span>
										</a>
									</li>
									<li>
										<a href="{{url('setting')}}">
											<span class="link-collapse">Settings</span>
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<ul class="nav nav-primary">
						<li class="nav-item  {{request()->segment(1)=='dashboard' ? 'active' :''}}">
							<a  href="{{url('dashboard')}}" class="collapsed" >
								<i class="fas fa-home"></i>
								<p>Dashboard</p>
							</a>
						</li>
						@if(Auth::user()->type=='admin')
						<li class="nav-item {{request()->segment(1)=='lottery' ? 'active' :''}}">
							<a  href="{{url('lottery')}}" class="collapsed" >
								<i class="fas fa-gift"></i>
								<p>Lottery</p>
							</a>
						</li>
						<li class="nav-item {{request()->segment(1)=='user' ? 'active' :''}}">
							<a  href="{{url('user')}}" class="collapsed" >
								<i class="fas fa-user"></i>
								<p>Users</p>
							</a>
						</li>
						
						
						
					
						@endif
						
					</ul>
					
				</div>
			</div>
		</div>