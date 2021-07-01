<!-- head area -->
@include('includes.admin-head')
<style>
.error{
    color:red;
}

</style>
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
                            <div class="col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8 col-xs-12">
                                <div class="login-form signup-form">
                                    <h4 class="login-title text-center">REGISTER</h4>
                                    <div class="row">
									@if(session('message'))
										<p class="alert alert-success">{{session('message')}}</p>
									@endif
									@if(session('login_message'))
										<p class="alert alert-danger">{{session('login_message')}}</p>
									@endif
                                       
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
        <script src="{{url('public/assets/js/plugin/jquery.validate/jquery.validate.min.js')}}"></script>
        <!--Datepickr-->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script> 
        <script>
            $(function() {
 
 $("#dob").datepicker({ 
       autoclose: true, 
       todayHighlight: true
 });
});
		$(document).ready(function(){
            
			setTimeout(function(){
		var url = "{{url('signin')}}";
		location.href =  url;
		; }, 5000);
	// For quantity validation
	 $(".numeric_feild").on("focus",function(event)
	 {
		id=$(this).attr('id');
		var text = document.getElementById(id);
		text.onkeypress = text.onpaste = checkInput;
	 });
	function checkInput(e) 
	{
	var e = e || event;
	var char = e.type == 'keypress' 
	? String.fromCharCode(e.keyCode || e.which) 
	: (e.clipboardData || window.clipboardData).getData('Text');
	if (/[^\d]/gi.test(char)) {
	return false;
	}
	}
	
	
   
		});

	</script>
	</body>
</html>
