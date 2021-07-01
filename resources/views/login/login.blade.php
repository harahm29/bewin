<!-- head area -->
@include('includes.admin-head')
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
                            <div class="col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6 col-xs-12">
                                <div class="login-form">
                                    <h4 class="login-title text-center">LOGIN</h4>
                                    <div class="row">
                                    @if(session('message'))
										<p class="alert alert-success">{{session('message')}}</p>
									@endif
									@if(session('login_message'))
										<p class="alert alert-danger">{{session('login_message')}}</p>
									@endif
                                        <form id="contactForm" method="POST" action="{{url('dologin')}}" class="log-form">
                                            @csrf
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
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <input type="email" id="email" name="email" class="form-control" placeholder="Username" required data-error="Please enter your name">
                                            </div>
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <input type="password" id="password" name="password" class="form-control" placeholder="Password" required data-error="Please enter your message subject">
                                            </div>
                                            <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                                                <div class="check-group flexbox">
                                                   <!-- <label class="check-box">
                                                        <input type="checkbox" class="check-box-input" checked>
                                                        <span class="remember-text">Remember me</span>
                                                    </label>-->

                                                    <a class="text-muted" href="{{'forget-password'}}">Forgot password?</a>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                                                <button type="submit" id="submit" class="slide-btn login-btn">Login</button>
                                                <div id="msgSubmit" class="h3 text-center hidden"></div> 
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                                                <div class="clear"></div>
                                                <!-- <div class="separetor text-center"><span>Or with Sign</span></div> -->
                                                <div class="sign-icon">
                                                    <!-- <ul>
                                                        <li><a class="facebook" href="#"><i class="fa fa-facebook-square"></i>Facebook</a></li>
                                                        <li><a class="twitter" href="#"><i class="fa fa-twitter-square"></i>twitter</a></li>
                                                        <li><a class="google" href="#"><i class="fa fa-google-plus-square"></i>google</a></li>
                                                    </ul> -->
                                                    <div class="acc-not">Don't have an account  <a href="{{url('signup')}}">Sign up</a></div>
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
	</body>
</html>
