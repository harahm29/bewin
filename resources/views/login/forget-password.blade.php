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
                                    <h4 class="login-title text-center">Forgot Password</h4>
                                    <div class="row">
                                    @if(session('message'))
				<p class="alert alert-success">{{session('message')}}</p>
            @endif
            @if(session('login_message'))
				<p class="alert alert-danger">{{session('login_message')}}</p>
			@endif
                                        <form id="contactForm" method="POST" action="{{url('forget-password')}}" class="log-form">
                                            @csrf
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <input type="email" id="email" name="email" class="form-control" placeholder="Username" required value="{{old('email')}}">
												<div class="text-danger error">{{$errors->first('email')}}</div>
                                            </div>
                                           
                                           
                                            <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                                                <button type="submit" id="submit" class="slide-btn login-btn">Login</button>
                                                <div id="msgSubmit" class="h3 text-center hidden"></div> 
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                                                <div class="clear"></div>
                                              
                                                <div class="sign-icon">
                                                   
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
	</body>
</html>
