<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>Registration</title>
<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
<link rel="icon" href="{{url('public/assets/img/icon.ico')}}" type="image/x-icon"/>

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
<div class="container container-login animated fadeIn">
<h3 class="text-center">Registration</h3>
@if(session('msg'))
           <p class="alert alert-success">{{session('msg')}}</p>
           @endif
<form action="{{url('registration')}}" method="post">
@csrf
<div class="login-form">
<div class="form-group form-floating-label">
<input  id="name" name="name" type="text" class="form-control input-border-bottom" required>
<label for="name" class="placeholder">Name</label>
<div class="text-danger">{{ $errors->first('name')}}
</div>
</div>
<div class="form-group form-floating-label">
<input  id="email" name="email" type="email" class="form-control input-border-bottom" required>
<label for="email" class="placeholder">Email</label>
<div class="text-danger">{{ $errors->first('email')}}
</div>
</div>
<div class="form-group form-floating-label">
<input  id="password" name="password" type="password" class="form-control input-border-bottom" required>
<label for="password" class="placeholder">Password</label>
   <div class="text-danger">{{ $errors->first('password')}}

</div>
</div>
<div class="form-group form-floating-label">
<input  id="mobile_no" name="mobile_no" type="text" class="form-control input-border-bottom" required>
<label for="password" class="placeholder">Mobile_no</label>
   <div class="text-danger">{{ $errors->first('mobile_no')}}

</div>
</div>

<div class="form-group form-floating-label">
<input  id="address" name="address" type="text" class="form-control input-border-bottom" required>
<label for="address" class="placeholder">Address</label>
   <div class="text-danger">{{ $errors->first('address')}}

</div>
</div>














<div class="row form-sub m-0">
<div class="custom-control custom-checkbox">
<input type="checkbox" class="custom-control-input" name="agree" id="agree">
<label class="custom-control-label" for="agree">I Agree the terms and conditions.</label>
</div>
</div>
<div class="form-action">
<a href="{{url('login')}}" id="show-signin" class="btn btn-danger btn-link btn-login mr-3">Already Registered</a>
<button type="submit" class="btn btn-primary btn-flat">Register</button>
</div>

</div>
 </form>
</div>


</div>
<script src="{{url('public/assets/js/core/jquery.3.2.1.min.js')}}"></script>
<script src="{{url('public/assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js')}}"></script>
<script src="{{url('public/assets/js/core/popper.min.js')}}"></script>
<script src="{{url('public/assets/js/core/bootstrap.min.js')}}"></script>
<script src="{{url('public/assets/js/atlantis.min.js')}}"></script>
</body>
</html>