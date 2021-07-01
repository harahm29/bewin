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
						
						
						<li class="nav-item {{request()->segment(1)=='user' ? 'active' :''}} 
							{{request()->segment(1)=='agent' ? 'active' :''}} ">
							<a data-toggle="collapse" href="#users">
								<i class="fas fa-user"></i>
								<p>Users</p>
								<span class="caret"></span>
							</a>
							<div class="collapse {{request()->segment(1)=='user' ? 'show' :''}} 
							{{request()->segment(1)=='agent' ? 'show' :''}}{{request()->segment(1)=='agent-code-listing' ? 'show' :''}}{{request()->segment(1)=='agent-history' ? 'show' :''}}{{request()->segment(1)=='user-history' ? 'show' :''}}" id="users">
								<ul class="nav nav-collapse">
									<li class="{{request()->segment(1)=='user'?'active':''}}{{request()->segment(1)=='user-history'?'active':''}}">
										<a  href="{{url('user')}}">
											<span class="sub-item"> User</span>
										</a>
									</li>
									<!--<li class="{{request()->segment(1)=='agent'?'active':''}}{{request()->segment(1)=='agent-history'?'active':''}}{{request()->segment(1)=='agent-code-listing'?'active':''}}">
										<a href="{{url('agent')}}">
											<span class="sub-item"> Agent</span>
										</a>
									</li>-->
									
								</ul>
							</div>
						</li>
						
						<li class="nav-item {{request()->segment(1)=='lottery' ? 'active' :''}} ">
							<a data-toggle="collapse" href="#lottery">
								<i class="fas fa-gift"></i>
								<p>Lottery</p>
								<span class="caret"></span>
							</a>
							<div class="collapse {{request()->segment(1)=='lottery' ? 'show' :''}} {{request()->segment(1)=='lottery-Content' ? 'lottery-Content' :''}}" id="lottery">
								<ul class="nav nav-collapse">
									<li class="{{request()->segment(2)==''?'active':''}}">
										<a  href="{{url('lottery')}}">
											<span class="sub-item"> List</span>
										</a>
									</li>
									<li class="{{request()->segment(2)=='create'?'active':''}}">
										<a href="{{url('lottery/create')}}">
											<span class="sub-item"> Create Lottery</span>
										</a>
									</li>
										
									
								</ul>
							</div>
						</li>
						<li class="nav-item {{request()->segment(1)=='voucher' ? 'active' :''}}{{request()->segment(1)=='commission' ? 'active' :''}} ">
							<a data-toggle="collapse" href="#voucher">
								<i class="fas fa-receipt"></i>
								<p>Voucher</p>
								<span class="caret"></span>
							</a>
							<div class="collapse {{request()->segment(1)=='voucher' ? 'show' :''}} {{request()->segment(1)=='commission' ? 'show' :''}} " id="voucher">
								<ul class="nav nav-collapse">
									<li class="{{request()->segment(1)=='voucher'?'active':''}}">
										<a  href="{{url('voucher')}}">
											<span class="sub-item"> Plan</span>
										</a>
									</li>
									<li class="{{request()->segment(1)=='commission'?'active':''}}">
										<a href="{{url('commission')}}">
											<span class="sub-item"> Agent Commission</span>
										</a>
									</li>
									<li class="{{request()->segment(1)=='voucher-Generate'?'active':''}}">
										<a href="{{url('voucher-Generate')}}">
											<span class="sub-item">Voucher Generate</span>
										</a>
									</li>
									
								</ul>
							</div>
						</li>
						
						
						
						<li class="nav-item {{request()->segment(1)=='transaction' ? 'active' :''}}{{request()->segment(1)=='agent-transaction' ? 'active' :''}} ">
							<a data-toggle="collapse" href="#transaction">
								<i class="fas fa-money-bill-alt"></i>
								<p>Transaction</p>
								<span class="caret"></span>
							</a>
							<div class="collapse {{request()->segment(1)=='transaction' ? 'show' :''}} {{request()->segment(1)=='agent-transaction' ? 'show' :''}} " id="transaction">
								<ul class="nav nav-collapse">
									<li class="{{request()->segment(1)=='transaction'?'active':''}}">
										<a  href="{{url('transaction')}}">
											<span class="sub-item"> User Transaction</span>
										</a>
									</li>
									<li class="{{request()->segment(1)=='agent-transaction'?'active':''}}">
										<a href="{{url('agent-transaction')}}">
											<span class="sub-item"> Agent Transaction</span>
										</a>
									</li>
									
								</ul>
							</div>
						</li>
					<!--	
						<li class="nav-item {{request()->segment(1)=='addlotteryticket' ? 'active' :''}}">
							<a  href="{{url('addlotteryticket')}}" class="collapsed" >
								<i class="fas fa-ticket-alt"></i>
								<p>Add Lottery Ticket</p>
							</a>
						</li>
						<li class="nav-item {{request()->segment(1)=='orders' ? 'active' :''}} 
							{{request()->segment(1)=='orders/pending' ? 'active' :''}} 
							{{request()->segment(1)=='orders/received' ? 'active' :''}} 
							{{request()->segment(1)=='orders/shipped' ? 'active' :''}} 
							{{request()->segment(1)=='orders/delivered' ? 'active' :''}} 
							{{request()->segment(1)=='orders/canceled' ? 'active' :''}}">
							<a data-toggle="collapse" href="#orders">
								<i class="fas fa-shopping-cart"></i>
								<p>Orders</p>
								<span class="caret"></span>
							</a>
							<div class="collapse {{request()->segment(1)=='orders' ? 'show' :''}} 
							{{request()->segment(1)=='orders/pending' ? 'show' :''}} 
							{{request()->segment(1)=='orders/received' ? 'show' :''}} 
							{{request()->segment(1)=='orders/shipped' ? 'show' :''}} 
							{{request()->segment(1)=='orders/delivered' ? 'show' :''}} 
							{{request()->segment(1)=='orders/canceled' ? 'show' :''}}" id="orders">
								<ul class="nav nav-collapse">
									<li class="{{(request()->segment(2)=='')?'active':''}}">
										<a  href="{{url('orders')}}">
											<span class="fab fa-first-order"> All Orders</span>
										</a>
									</li>
									<li class="{{(request()->segment(2)=='complete')?'active':''}}">
										<a href="{{url('orders/complete')}}">
											<span class="fas fa-check text-success"> Complete</span>
										</a>
									</li>
									<li class="{{(request()->segment(2)=='failed')?'active':''}}">
										<a href="{{url('orders/failed')}}">
											<span class="fas fa-times text-danger"> Failed</span>
										</a>
									</li>
								</ul>
							</div>
						</li>
						<li class="nav-item {{request()->segment(1)=='voucher' ? 'active' :''}}">
							<a  href="{{url('voucher')}}" class="collapsed" >
								<i class="fas fa-receipt"></i>
								<p>Voucher</p>
							</a>
						</li>
						<li class="nav-item {{request()->segment(1)=='commission' ? 'active' :''}}">
							<a  href="{{url('commission')}}" class="collapsed" >
								<i class="fas fa-money-bill-wave"></i>
								<p>Commission</p>
							</a>
						</li>
						-->
						<li class="nav-item {{request()->segment(1)=='withdraw' ? 'active' :''}}">
							<a  href="{{url('withdraw')}}" class="collapsed" >
								<i class="fas fa-money-bill-wave"></i>
								<p>Withdraw Request</p>
							</a>
						</li>
						<li class="nav-item {{request()->segment(1)=='pastwinner' ? 'active' :''}}">
							<a  href="{{url('pastwinner')}}" class="collapsed" >
								<i class="fas fa-trophy"></i>
								<p>Past Winners</p>
							</a>
						</li> 
						<li class="nav-item {{request()->segment(1)=='count-lottery-ticket' ? 'active' :''}}">
							<a  href="{{url('count-lottery-ticket')}}" class="collapsed" >
								<i class="fas fa-ticket-alt"></i>
								<p>Total Sold Ticket</p>
							</a>
						</li> 
						<li class="nav-item {{request()->segment(1)=='show-winner-name' ? 'active' :''}}">
							<a  href="{{url('show-winner-name')}}" class="collapsed" >
								<i class="fas fa-trophy"></i>
								<p>Winners Name</p>
							</a>
						</li> 
						<li class="nav-item {{request()->segment(1)=='show-winner-number' ? 'active' :''}}">
							<a  href="{{url('show-winner-number')}}" class="collapsed" >
								<i class="fas fa-trophy"></i>
								<p>Winners Number</p>
							</a>
						</li> 
						
						<li class="nav-item {{request()->segment(1)=='home' ? 'active' :''}}{{request()->segment(1)=='content' ? 'active' :''}}{{request()->segment(1)=='faq' ? 'active' :''}} {{request()->segment(1)=='about' ? 'active' :''}} {{request()->segment(1)=='privacy' ? 'active' :''}} {{request()->segment(1)=='termandcondition' ? 'active' :''}}{{request()->segment(1)=='sociallink' ? 'active' :''}} ">
							<a data-toggle="collapse" href="#content">
							<i class="fas fa-text-width"></i>
								<p>Content Page</p>
								<span class="caret"></span>
							</a>
							<div class="collapse {{request()->segment(1)=='home' ? 'show' :''}}{{request()->segment(1)=='lottery-Content' ? 'show' :''}} {{request()->segment(1)=='contact' ? 'show' :''}}{{request()->segment(1)=='faq' ? 'show' :''}}{{request()->segment(1)=='about' ? 'show' :''}}{{request()->segment(1)=='privacy' ? 'show' :''}}{{request()->segment(1)=='termandcondition' ? 'show' :''}}{{request()->segment(1)=='sociallink' ? 'show' :''}} " id="content">
								<ul class="nav nav-collapse">
									<li class="{{request()->segment(1)=='about'?'active':''}}">
										<a  href="{{url('about')}}">
											<span class="sub-item"> About Us</span>
										</a>
									</li>
									<li class="{{request()->segment(1)=='lottery-Content'?'active':''}}">
										<a href="{{url('lottery-Content')}}">
											<span class="sub-item">Lottery Content</span>
										</a>
									</li>
									<li class="{{request()->segment(1)=='faq'?'active':''}}">
										<a  href="{{url('faq')}}">
											<span class="sub-item"> FAQs</span>
										</a>
									</li>
									<li class="{{request()->segment(1)=='contact'?'active':''}}">
										<a  href="{{url('contact')}}">
											<span class="sub-item"> Contact</span>
										</a>
									</li>
									<li class="{{request()->segment(1)=='home'?'active':''}}">
										<a  href="{{url('home')}}">
											<span class="sub-item"> Home</span>
										</a>
									</li>
									<li class="{{request()->segment(1)=='privacy'?'active':''}}">
										<a  href="{{url('privacy')}}">
											<span class="sub-item"> Privacy</span>
										</a>
									</li>
									<li class="{{request()->segment(1)=='termandcondition'?'active':''}}">
										<a  href="{{url('termandcondition')}}">
											<span class="sub-item"> Term And Condition</span>
										</a>
									</li>
									<li class="{{request()->segment(1)=='sociallink'?'active':''}}">
										<a  href="{{url('sociallink')}}">
											<span class="sub-item"> Social Link</span>
										</a>
									</li>
									
									
								</ul>
							</div>
						</li>
						
						@endif
						
						<li class="nav-item">
							<a  href="http://localhost/bewin/signup/{{Auth::user()->username}}" target="_balnk" class="collapsed" >
								<i class="fas fa-trophy"></i>
								<p>Refferal URL</p>
							</a>
						</li> 

					</ul>
					
				</div>
			</div>
		</div>