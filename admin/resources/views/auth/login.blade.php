
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>Login</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="{{url('public/assets/img/icon.ico" type="image/x-icon')}}"/>

	<!-- Fonts and icons -->
	<script src="{{url('public/assets/js/plugin/webfont/webfont.min.js')}}"></script>
	<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ["{{url('public/assets/css/fonts.min.css')}}"]},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>
	
	<!-- CSS Files -->
	<link rel="stylesheet" href="{{url('public/assets/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{url('public/assets/css/atlantis.min.css')}}">
</head>
<body class="login">
 

	<div class="wrapper wrapper-login">
	
			<form action="{{url('dologin')}}" method="post">
			 @csrf
			<div class="whole-signin" id="test">
		<div class="container container-login animated fadeIn" ><h3 class="text-center">{{env("APP_NAME")}}</h3>
		 <a href="{{url('dashboard')}}" class="logo">
				<!--	<img src="{{url('public/images/b2_logo.png')}}" alt="..." class=" rounded-circle" style="width:100px; margin-left:113px; margin-bottom:11px;">-->
				</a>
			
			<!--<h3 class="text-center">Log in</h3>
			<p class="login-box-msg" align="center">Sign in to start your session</p> -->
   @if(session('message'))
   <p class="alert alert-success">{{session('message')}}</p>
   @endif
@if(session('errorMsg'))
   <p class="alert alert-danger">{{session('errorMsg')}}</p>
   @endif




    @if(session('msg'))
<p class="alert alert-success">{{session('msg')}}</p>
   @endif
            
			<div class="login-form">
			
				<div class="form-group form-floating-label">
					<input id="email" name="email" type="text" class="form-control input-border-bottom" required>
					<label for="email" class="placeholder"><b>Email</b></label>
					<div class="text-danger">{{$errors->first('email')}}</div>
				</div>
				<div class="form-group form-floating-label">
					<input id="password" name="password" type="password" class="form-control input-border-bottom" required>
					<label for="password" class="placeholder"><b>Password</b></label>
					<div class="text-danger">{{$errors->first('password')}}</div>
					<div class="show-password">
						<i class="icon-eye"></i>
					</div>
				</div>
				<div class="row form-sub m-0">
				<!--	<div class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input" id="rememberme">
						<label class="custom-control-label" for="rememberme">Remember Me</label>
					</div> -->
					
					
				</div>
				<div class="form-action mb-3">
					 <button type="submit"  class="btn btn-primary btn-block btn-flat">Log In</button>
				</div>
			
			</div>
			</form>
		</div>
		</div>
<div class="whole-signup">
		<div class="container container-signup animated fadeIn">
			<h3 class="text-center">Sign Up</h3>
			<div class="login-form">
				<div class="form-group form-floating-label">
					<input  id="fullname" name="fullname" type="text" class="form-control input-border-bottom" required>
					<label for="fullname" class="placeholder">Fullname</label>
				</div>
				<div class="form-group form-floating-label">
					<input  id="email" name="email" type="email" class="form-control input-border-bottom" required>
					<label for="email" class="placeholder">Email</label>
				</div>
				<div class="form-group form-floating-label">
					<input  id="passwordsignin" name="passwordsignin" type="password" class="form-control input-border-bottom" required>
					<label for="passwordsignin" class="placeholder">Password</label>
					<div class="show-password">
						<i class="icon-eye"></i>
					</div>
				</div>
				
				<div class="row form-sub m-0">
					<div class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input" name="agree" id="agree">
						<label class="custom-control-label" for="agree">I Agree the terms and conditions.</label>
					</div>
				</div>
				<div class="form-action">
					<a href="#" id="show-signin" class="btn btn-danger btn-link btn-login mr-3">Cancel</a>
					<a href="#" class="btn btn-primary btn-rounded btn-login">Sign Up</a>
				</div>
			</div>
		</div>
	</div>
	
		<div class="forget-form " id="forget1" style="display:none">
	<div class="container container-login animated fadeIn">
	<form method="post" action="{{url('/forget-password')}}">
	@csrf
	 <a href="{{url('dashboard')}}" class="logo">
					<img src="{{url('public/images/b2_logo.png')}}" alt="..." class=" rounded-circle" style="width:100px; margin-left:113px; margin-bottom:11px;">
				</a>
	
				<div class="form-group form-floating-label">
					<input id="email" name="email" type="text" class="form-control input-border-bottom" required>
					<label for="Email" class="placeholder">Email</label>
				</div>
			
				
				<div class="form-action mb-3">
					<button type="submit"  class="btn btn-primary btn-rounded btn-login mr-3">Submit</button>
				</div>
				</form>
				<div class="login-account">
					<span class="msg">Did you have password</span>
					<a href="#"  class="link login-page">Sign In</a>
				</div>
				
			</div>
			</div>
	</div>
	
	<script src="{{url('public/assets/js/core/jquery.3.2.1.min.js')}}"></script>
	<script src="{{url('public/assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js')}}"></script>
	<script src="{{url('public/assets/js/core/popper.min.js')}}"></script>
	<script src="{{url('public/assets/js/core/bootstrap.min.js')}}"></script>
	<script src="{{url('public/assets/js/atlantis.min.js')}}"></script>
	<script>
    $(document).ready(function(){
 
   $('.alert-success').fadeOut(5000);
     });
	 
	 $(document).ready(function(){
  $("#forget-button").click(function(){
    $("#forget1").show();
    $(".whole-signin").hide();
    $(".whole-signup").hide();
  });
  $(".login-page").click(function(){
	  $(".whole-signin").show();
	  $(".whole-signup").hide();
	 $("#forget1").hide();
	  
  });
});
 </script>

</body>
</html>