
<footer class="footer">
<div class="container-fluid">
<nav class="pull-left">
<ul class="nav">
<li class="nav-item">
<a class="nav-link" href="http://www.themekita.com">
ThemeKita
</a>
</li>
<li class="nav-item">
<a class="nav-link" href="#">
Help
</a>
</li>
<li class="nav-item">
<a class="nav-link" href="#">
Licenses
</a>
</li>
</ul>
</nav>
<div class="copyright ml-auto">
2018, made with <i class="fa fa-heart heart text-danger"></i> by <a href="http://www.themekita.com">{{env("APP_NAME")}}</a>
</div>	
</div>
</footer>
               <input type="hidden" id="img_url" value="{{url('public/images/loader.gif')}}" />
			 
</div>
				<input type="hidden" id="order_detail_url" value="{{url('order-details')}}" />
               <input type="hidden" id="img_url" value="{{url('public/images/loader.gif')}}" />
               <input type="hidden" id="update_status_url" value="{{url('update-status')}}" />
               <meta name="csrf-token" content="{{ csrf_token() }}" />
<!--   Core JS Files   -->
	
	<script src="{{url('public/assets/js/core/popper.min.js')}}"></script>
	<script src="{{url('public/assets/js/core/bootstrap.min.js')}}"></script>
    
	<!-- jQuery UI -->
	<script src="{{url('public/assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js')}}"></script>
	<script src="{{url('public/assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js')}}"></script>
	<!-- Moment JS -->
	<script src="{{url('public/assets/js/plugin/moment/moment.min.js')}}"></script>
	<!-- Bootstrap Toggle -->
	<script src="{{url('public/assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js')}}"></script>
	<!-- jQuery Scrollbar -->
	<script src="{{url('public/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>
	<!-- Select2 -->
	<script src="{{url('public/assets/js/plugin/select2/select2.full.min.js')}}"></script>
	<!-- jQuery Validation
	<script src="{{url('public/assets/js/plugin/jquery.validate/jquery.validate.min.js')}}"></script> -->
	 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
	 
 
	<!-- Chart JS -->
	<script src="{{url('public/assets/js/plugin/chart.js/chart.min.js')}}"></script>

	<!-- jQuery Sparkline -->
	<script src="{{url('public/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js')}}"></script>

	<!-- Chart Circle -->
	<script src="{{url('public/assets/js/plugin/chart-circle/circles.min.js')}}"></script>

	<!-- Datatables -->
	<script src="{{url('public/assets/js/plugin/datatables/datatables.min.js')}}"></script>
    <script src="http://malsup.github.com/jquery.form.js"></script>
	<!-- Bootstrap Notify -->
	<script src="{{url('public/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js')}}"></script>

	<!-- jQuery Vector Maps -->
	<script src="{{url('public/assets/js/plugin/jqvmap/jquery.vmap.min.js')}}"></script>
	<script src="{{url('public/assets/js/plugin/jqvmap/maps/jquery.vmap.world.js')}}"></script>

	<!-- Sweet Alert -->
	<script src="{{url('public/assets/js/plugin/sweetalert/sweetalert.min.js')}}"></script>

	<!-- Atlantis JS -->
	<script src="{{url('public/assets/js/atlantis.min.js')}}"></script>

	<!-- Atlantis DEMO methods, don't include it in your project! -->
	<script src="{{url('public/assets/js/setting-demo.js')}}"></script>
	
	<!--Datepickr-->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
	<!-- Bootbox -->
<script src="{{asset('public/assets/js/plugin/bootbox/bootbox.min.js')}}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
 
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
	$(".select2").select2();
	
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
