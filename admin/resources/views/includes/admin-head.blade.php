<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
 <title>@yield('title')</title>
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
	<link rel="stylesheet" href="{{url('public/assets/css/fonts.min.css')}}">
	<link rel="stylesheet" href="{{url('public/assets/css/atlantis.min.css')}}">

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link rel="stylesheet" href="{{url('public/assets/css/demo.css')}}">
	

<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
  <meta id="csrf-token" name="csrf-token" content="{{ csrf_token() }}" />
  <meta id="user-id" name="user-id" content="{{ Auth::check() ? Auth::user()->id:'' }}" />
</head>