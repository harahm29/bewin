<!doctype html>
<html class="no-js" lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<title style="text-transform: uppercase;">  {{env("APP_NAME")}}</title>
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- favicon -->		
		<link rel="shortcut icon" type="image/x-icon" href="{{url('public/frontend/img/logo/favicon.ico')}}">

		<!-- all css here -->

		<!-- bootstrap v3.3.6 css -->
		<link rel="stylesheet" href="{{url('public/frontend/css/bootstrap.min.css')}}">
		<!-- owl.carousel css -->
		<link rel="stylesheet" href="{{url('public/frontend/css/owl.carousel.css')}}">
		<link rel="stylesheet" href="{{url('public/frontend/css/owl.transitions.css')}}">
       <!-- Animate css -->
        <link rel="stylesheet" href="{{url('public/frontend/css/animate.css')}}">
        <!-- meanmenu css -->
        <link rel="stylesheet" href="{{url('public/frontend/css/meanmenu.min.css')}}">
		<!-- font-awesome css -->
		<link rel="stylesheet" href="{{url('public/frontend/css/font-awesome.min.css')}}">
		<link rel="stylesheet" href="{{url('public/frontend/css/themify-icons.css')}}">
		<!-- magnific css -->
        <link rel="stylesheet" href="{{url('public/frontend/css/magnific.min.css')}}">
		<!-- style css -->
		<link rel="stylesheet" href="{{url('public/frontend/style.css')}}">
		<!-- responsive css -->
		<link rel="stylesheet" href="{{url('public/frontend/css/responsive.css')}}">

		<!-- modernizr css -->
		<script src="{{url('public/frontend/js/vendor/modernizr-2.8.3.min.js')}}"></script>
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
	<link rel="stylesheet" href="{{url('public/assets/css/fonts.min.css')}}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.css">
	<style>
	.error{
		color:red;
	}
	</style>
	</head>