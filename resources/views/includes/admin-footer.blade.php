<!-- Start Footer Area -->
<footer class="footer-1">
           <!--   <div class="footer-area">
                <div class="container">
                    <div class="row">
				  	<div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="footer-content logo-footer">
                                <div class="footer-head">
                                 <div class="footer-logo">
                                    	<a class="footer-black-logo" href="#" style="text-transform: uppercase;"><!--<img src="{{url('public/frontend/img/logo/logo.png')}}" alt=""> {{env("APP_NAME")}}</a>
                                    </div>
                                   <p>
                                        Replacing a  maintains the amount of lines. When replacing a selection. help agencies to define their new business objectives and then create. Replacing a  maintains the amount of lines. help agencies to define their new business objectives and then create. Replacing a  maintains the amount of lines.  
                                    </p>
                                    <div class="footer-icons">
                                        <ul>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-facebook" style="margin-top: 9px;"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-twitter" style="margin-top: 9px;"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-google"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-pinterest"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-instagram"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div> 
                                </div>
                            </div>
                        </div>-->
                        <!-- end single footer -->
                       <!-- <div class="col-md-2 col-sm-3 col-xs-12">
                            <div class="footer-content">
                                <div class="footer-head">
                                    <h4>Lottery Name</h4>
                                    <ul class="footer-list">
                                        <li><a href="#">Powerball</a></li>
                                        <li><a href="#">London Jackpot</a></li>
                                        <li><a href="#">Hunter Game</a></li>
                                        <li><a href="#">Royal Casino</a></li>
                                        <li><a href="#">Align fight</a></li>
                                        <li><a href="#">Black night</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>-->
                        <!-- end single footer -->
                       <!-- <div class="col-md-2 hidden-sm col-xs-12">
                            <div class="footer-content">
                                <div class="footer-head">
                                    <h4>Payments</h4>
                                    <ul class="footer-list">
                                        <li><a href="#">Ripple coin</a></li>
                                        <li><a href="#">Bitcoin</a></li>
                                        <li><a href="#">Ethireum</a></li>
                                        <li><a href="#">Light coin</a></li>
                                        <li><a href="#">Coin base</a></li>
                                        <li><a href="#">Skrill card</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>-->
                        <!-- end single footer -->
                        <!--<div class="col-md-2 col-sm-3 col-xs-12">
                             <div class="footer-content last-content">
                                <div class="footer-head">
                                    <h4>Support</h4>
                                    <ul class="footer-list">
                                        <li><a href="#">Customer Care</a></li>
                                        <li><a href="#">Live chat</a></li>
                                        <li><a href="#">Notification</a></li>
                                        <li><a href="#">Privacy</a></li>
                                        <li><a href="#">Terms & Condition</a></li>
                                        <li><a href="#">Contact us </a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>-->
            <!-- Start Footer Bottom Area -->
            <div class="footer-area-bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 ">
						 <div class="col-sm-3 ">
                            <div class="footer-content">
                                <div class="footer-head">
                                  
                                    <ul class="footer-list">
                                       <li><a href="{{url('privacy')}}">Privacy</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- end single footer -->
                        <div class="col-md-5">
                            <div class="footer-content">
                                <div class="footer-head">
                                   
                                    <ul class="footer-list">
                                        <li><a href="{{url('term-and-condition')}}">Terms & Condition</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- end single footer -->
                        <div class="col-sm-3 ">
                             <div class="footer-content last-content">
                                <div class="footer-head">
                                   
                                    <ul class="footer-list">
                                        <li><a href="#">Contact us </a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
						</div>
                        <div class="col-md-6 col-sm-6 pull-right " align="right">
                            <div class="copyright">
                                <p>
                                    Copyright © 2020
                                    <a href="#">{{env("APP_NAME")}}</a> All Rights Reserved
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Footer Bottom Area -->
        </footer>
		<input type="hidden" id="order_detail_url" value="{{url('order-details')}}" />
               <input type="hidden" id="img_url" value="{{url('public/images/loader.gif')}}" />
               <input type="hidden" id="update_status_url" value="{{url('update-status')}}" />
               <meta name="csrf-token" content="{{ csrf_token() }}" />
        <!-- End Footer Area -->
		
		<!-- all js here -->

		<!-- jquery latest version -->
		<script src="{{url('public/frontend/js/vendor/jquery-1.12.4.min.js')}}"></script>
		<script src="{{url('public/assets/js/core/popper.min.js')}}"></script>
		<!-- bootstrap js -->
		<script src="{{url('public/frontend/js/bootstrap.min.js')}}"></script>
		<!-- owl.carousel js -->
		<script src="{{url('public/frontend/js/owl.carousel.min.js')}}"></script>
		<!-- magnific js -->
        <script src="{{url('public/frontend/js/magnific.min.js')}}"></script>
        <!-- wow js -->
        <script src="{{url('public/frontend/js/wow.min.js')}}"></script>
        <!-- meanmenu js -->
        <script src="{{url('public/frontend/js/jquery.meanmenu.js')}}"></script>
		<!-- Form validator js -->
		<script src="{{url('public/frontend/js/form-validator.min.js')}}"></script>
		<!-- plugins js -->
		<script src="{{url('public/frontend/js/plugins.js')}}"></script>
		<!-- main js -->
		<script src="{{url('public/frontend/js/main.js')}}"></script>
			<!-- Bootbox -->
<script src="{{asset('public/assets/js/plugin/bootbox/bootbox.min.js')}}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<!-- Datatables -->
	<script src="{{url('public/assets/js/plugin/datatables/datatables.min.js')}}"></script>
		    <!--Datepickr-->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script> 
<script src="{{url('public/assets/js/plugin/jquery.validate/jquery.validate.min.js')}}"></script>
<script>

$(function() {
 
    $(".alert-success").fadeOut(5000);
    $(".alert-danger").fadeOut(5000);
});
$(function () {
  $('#example1').DataTable({
  'paging'      : true,
    'lengthChange': true,
    'searching'   : true,
    'ordering'    : true,
    'info'        : true,
    'autoWidth'   : true
 
  });
  
    
});



	$(document).ready(function(){
		$(".stop_lottery").click(function(e){
					e.preventDefault();
				})
		 $("body").tooltip({ selector: '[data-toggle=tooltip]' });
		 
			var img_url =  $("#img_url").val();
		
		// view
		$(".view").click(function(e){
	    e.preventDefault();
						
		$("#view_modal").modal();
			var id = $(this).attr('id');
			
			var url = $(this).attr('href');
			$.ajax({
			  url:url,
			  data:{id:id},
			  type:"get",
			  beforeSend: function() {// setting a timeout
					$(".modal-body").html("<img src='"+img_url+"' style='width: 15%;' />");
				  },
			  success:function(data)
			  {
				$(".modal-body").html(data);
			  }
			})
		});
		
		// Delete 
		$(".delete").click(function(e){
		e.preventDefault();
		var id = $(this).attr('id');
		 bootbox.confirm({
		  message:"Are you sure you want to delete this entry?",
		  buttons:{ cancel: {
            label: '<i class="fa fa-times"></i> Cancel'
			},
			confirm: {
				label: '<i class="fa fa-check"></i> Confirm'
			},
			  },
		    callback: function (result) {
				if(result){
						
			  $('#delete_form_'+id).submit();
				}
			}
		  })//confirm
		});
 
		$('form').submit(function() {
			//$('#loadingDiv').show();
		});
       $('#exampleValidation').submit(function() {
			//$('#loadingDiv').show();
		});

    $( document ).on( 'focus', ':input', function(){
        $( this ).attr( 'autocomplete', 'off' );
    });
	//$(".select2").select2();
	
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
	
	//For discount validation
	$(".numeric_feild_discount").keypress(function(event){
		return isNumber(event, this);
    });	

	 function isNumber(evt, element)
	 {
		 var charCode = (evt.which) ? evt.which : event.keyCode
		 if (
				(charCode != 45 || $(element).val().indexOf('-') != -1) &&      // “-” CHECK MINUS, AND ONLY ONE.
				(charCode != 46 || $(element).val().indexOf('.') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
				(charCode < 48 || charCode > 57))
				return false;

				return true;
	  }
});
function save_admin_message_settings(id)
	{
		var status = $(".status_"+id+":checked").val();
		if(status!=1)
			status =0;
		var type = $(".status_"+id).attr('type_status');
		//alert(type);
		var _token = $('input[name="_token"]').val();
		$.ajax({
			url:"{{url('update-status')}}",
			type:"post",
			data:{id:id,status:status,_token:_token,type:type},
			success:function(data){
				    var msg= "Status Updated Successfully";
					var title= "Success";
					var type= "success";
					notification_msg(msg,title,type);
			}
		});
	}
	function notification_msg(msg,title,type)
{
          var shortCutFunction = type;//'success'; //$("#toastTypeGroup input:radio:checked").val();
            //alert(shortCutFunction);
            var msg = msg;
            var title = title;
            var $showDuration = 300;
            var $hideDuration = 1000;
            var $timeOut = 5000;
            var $extendedTimeOut = 1000;
            //var toastIndex = toastCount++;
             
            var $toast = toastr[shortCutFunction](msg, title); // Wire up an event handler to a button in the toast, if it exists
            $toastlast = $toast;

            if(typeof $toast === 'undefined'){
                return;
            }
 
}
</script>