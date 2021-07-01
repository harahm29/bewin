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
<style>
.dropbtn {
  background-color: #4CAF50;
  color: white;
  padding: 16px;
  font-size: 16px;
  border: none;
}

.dropdown {
  position: relative;
  display: inline-block;
  width: 250px;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 150px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
  margin-top: 17px;

}

.dropdown-content a {
  color: black;
  padding: 10px 32px;
  text-decoration: none;
  display: block;
  float:left;
}

.dropdown-content a:hover {background-color: #ddd;}

.dropdown:hover .dropdown-content {display: block;}

.dropdown:hover .dropbtn {background-color: #3e8e41;}
</style>
<div id="loadingDiv" style="display:none;" >
    <div>
        <h7>Please wait...</h7>
    </div>
</div>
<!-- Header Start-->
<header class="header-one">
            <!-- Start top bar -->
            <div class="topbar-area">
                <div class="container">
                    <div class="row">
                        <div class=" col-md-6 col-sm-6 col-xs-12">
                            <div class="topbar-left">
                                <ul>
								@php 
								$social_link_count = DB::table("social_links")->count();
								if($social_link_count > 0)
								{
									$social_link = DB::table("social_links")->first();
									$facebook = $social_link->facebook;
									$instagram = $social_link->instagram;
								}
								else
								{
									$facebook = "";
									$instagram = "";
								}
								
								@endphp
                                  <!-- <li><a href="#"><i class="fa fa-clock-o"></i> Live support</a></li>-->
                                    <li><a href="{{url($facebook)}}"> <i class="fa fa-facebook" style="margin-top: 9px;"></i></a></li> 
                                    <li><a href="{{url($instagram)}}"> <i class="fab fa-instagram"></i></li></a> 
                                    <li><a href="#"><i class="fa fa-envelope"></i> info@BeWin.one</a></li> 
                                </ul>  
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="topbar-right">
							@if(Auth::check())
							@php	$transaction = DB::table('transactions as B')
								->select([DB::raw("sum(B.dr) as total_dr"),DB::raw("sum(B.cr) as total_cr")])
								->where(['B.is_deleted'=>0,'user_id'=>Auth::user()->id])
								//->groupBy(['B.id'])
								->first();	
								$wallet = $transaction->total_cr - $transaction->total_dr;
								session(["wallet"=>$wallet]);
								//echo "<pre>";
								//print_r($transaction);exit;@endphp
								@else
							@php	$wallet = 0; session(["wallet"=>$wallet]);@endphp
								@endif
								<ul>
								@if(Auth::check())
									@if(Auth::user()->type=='user')
                                    <li><span href="#" style="color: #dbeee1;display: block;padding: 12px 30px 10px 0px;position: relative;font-size: 15px;">My Balance : ${{$wallet}}</span>
                                    </li> 
									@endif
									<li><a href="#"><img src="{{url('public/frontend/img/icon/login.png')}}" alt="">My Account</a>
                                       <ul style="width: 151px;">
                                           <li><a href="{{url('profile')}}"><i class="fas fa-info-circle"></i> Personal Info</a>
										   @if(Auth::user()->type=='user')
                                          <li><a href="{{url('add-money')}}"><i class="fas fa-university"></i> Add Money</a>
									       <li><a href="{{url('my-history')}}"><i class="fas fa-history"></i> My History</a>
											@else
                                           <li><a href="{{url('code-purchase')}}"><i class="fab fa-centercode"></i> Code Purchase</a>
									        <li><a href="{{url('transaction')}}"><i class="fas fa-history"></i> My History</a>
											
											@endif
                                          <li><a href="{{url('change-password')}}"><i class="fas fa-lock"></i> Change Password</a>
                                          
                                       </ul>
                                    </li>
									@endif
                                    <li>
                                    @if(Auth::check())
                                    <a href="{{url('logout')}}"><img src="{{url('public/frontend/img/icon/login.png')}}" alt="">Logout</a>
                                    @else
                                    <a href="{{url('signin')}}"><img src="{{url('public/frontend/img/icon/login.png')}}" alt="">Login</a>
                                    @endif
									</li>
                                </ul>
							</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End top bar -->
            <!-- header-area start -->
            <div id="sticker" class="header-area hidden-xs">
                <div class="container">
                    <div class="row">
                        <!-- logo start -->
                        <div class="col-md-2 col-sm-2">
                            <div class="logo">
                                <!-- Brand -->
                                <a class="navbar-brand " href="{{url('/')}}" style="text-transform: uppercase;">
                                 <!--   <img src="{{url('public/frontend/img/logo/logo.png')}}" alt=""> -->
								 {{env("APP_NAME")}}
                                </a>
                            </div>
                            <!-- logo end -->
                        </div>
                        <div class="col-md-10 col-sm-10">
                            <div class="header-right-link">
							
								
								
                                <!-- search option end -->
								@if(Auth::check()) 
								  <a class="s-menu dropbtn" href="{{url('signin')}}">{{Auth::user()->first_name}} {{Auth::user()->last_name}}  </a>
								@else
								<a class="s-menu" href="{{url('signup')}}">   Join now</a>
							 @endif
                            </div>
                            <!-- mainmenu start -->
                            <nav class="navbar navbar-default">
                                <div class="collapse navbar-collapse" id="navbar-example">
                                    <div class="main-menu">
                                        <ul class="nav navbar-nav navbar-right">
                                            <li><a class="pages" href="{{url('/')}}">Home</a>
                                              <!--  <ul class="sub-menu">
                                                    <li><a href="{{url('/')}}">Home 01</a></li>
                                                    <li><a href="index-2.html">Home 02</a></li>
                                                </ul>-->
                                            </li>
                                            <li><a class="pages" href="{{url('about')}}">About Us</a></li>
                                           <!-- <li><a class="pages" href="#">Results</a>
                                                <ul class="sub-menu">
                                                    <li><a href="results.html">Results</a></li>
                                                    <li><a href="latest-win.html">Latest Winner</a></li>
                                                </ul>
                                            </li>-->
											@if(Auth::check() && Auth::user()->type=='agent')
											@else
                                            <li><a class="pages" href="{{url('lottery')}}">Lottery</a>
                                            
                                            </li>
											@endif
                                            <li><a href="{{url('faqs')}}">FAQ<small>s</small></a></li>
                                            <li><a href="{{url('past-winners')}}">PAST WINNING NUMBERS</a></li>
                                            <li><a href="{{url('contacts')}}">Contact Us</a></li>
											
											
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                            <!-- mainmenu end -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- header-area end -->
            <!-- mobile-menu-area start -->
            <div class="mobile-menu-area hidden-lg hidden-md hidden-sm">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mobile-menu">
                                <div class="logo">
                                    <a href="{{url('/')}}"><!--<img src="{{url('public/frontend/img/logo/logo.png')}}" alt="" />--> {{env("APP_NAME")}}</a>
                                </div>
                                <nav id="dropdown">
                                    <ul>
                                        <li><a class="pages" href="{{url('/')}}">Home</a>
                                            
                                        </li>
                                        <li><a class="pages" href="{{url('about')}}">About</a></li>
                                        <!--<li><a class="pages" href="{{url('result')}}">Results</a>-->
                                           
                                        </li>
										@if(Auth::check() && Auth::user()->type=='agent')
									    @else
                                        <li><a class="pages" href="{{url('lottery')}}">Lottery</a> </li>
									    @endif
                                       <li><a href="{{url('faqs')}}">FAQ<small>s</small></a></li>
                                       <li><a href="{{url('past-winners')}}">PAST WINNING NUMBERS
										</a></li>
                                       <li><a href="{{url('contacts')}}">Contact Us</a></li>
										
											
                                    </ul>
                                </nav>
                            </div>					
                        </div>
                    </div>
                </div>
            </div>
            <!-- mobile-menu-area end -->		
        </header>
        <!-- header end -->