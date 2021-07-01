@extends('layouts.admin')
@section('title','Notification')
@section('content')
<style>
.cus_box_info
{
	background-color: #24313C; padding: 10px; margin: 10px;
}

.cus_body_box
{
	background-color: #1C2331; padding: 10px; margin: 10px;color:white; 
}

.cus_head_box
{
	height: 40px; padding-top:10px; margin-top: 0px; background-color:#1AB188;
}

.detail_cus  { padding-top: 7px; margin-top: 7px; }
.box_footer_cus  { background-color: #1AB188; padding-top: 7px; margin-top: 7px; }


.status_checkbox{
visibility: hidden;
}

/* SLIDE THREE */
.slideparam {
width: 80px;
height: 26px;
background: #333;
margin: 2px auto;

-webkit-border-radius: 50px;
-moz-border-radius: 50px;
border-radius: 50px;
position: relative;

-webkit-box-shadow: inset 0px 1px 1px rgba(0,0,0,0.5), 0px 1px 0px rgba(255,255,255,0.2);
-moz-box-shadow: inset 0px 1px 1px rgba(0,0,0,0.5), 0px 1px 0px rgba(255,255,255,0.2);
box-shadow: inset 0px 1px 1px rgba(0,0,0,0.5), 0px 1px 0px rgba(255,255,255,0.2);

}

.slideparam:after {
content: 'OFF';
font: 12px/26px Arial, sans-serif;
color: #7a121d;
position: absolute;
right: 10px;
z-index: 0;
font-weight: bold;
text-shadow: 1px 1px 0px rgba(255,255,255,.15);
}

.slideparam:before {
content: 'ON';
font: 12px/26px Arial, sans-serif;
color: #00bf00;
position: absolute;
left: 10px;
z-index: 0;
font-weight: bold;
}

.slideparam label {
display: block;
width: 34px;
height: 20px;
cursor: pointer;
-webkit-border-radius: 50px;
-moz-border-radius: 50px;
border-radius: 50px;
 
-webkit-transition: all .4s ease;
-moz-transition: all .4s ease;
-o-transition: all .4s ease;
-ms-transition: all .4s ease;
transition: all .4s ease;
position: absolute;
top: 3px;
left: 3px;
z-index: 1;

-webkit-box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.3);
-moz-box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.3);
box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.3);
background: #fff;


filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fcfff4', endColorstr='#b3bead',GradientType=0 );
}

.slideparam input[type=checkbox]:checked + label {
left: 43px;
}


 .slideparam input[type=checkbox]:checked + label:after {
   background: #27ae60;
}
 
.slideparam label:after {
   content:'';
   width: 10px;
   height: 10px;
   position: absolute;
   top: 5px;
   left: 12px;
   background: red;
   border-radius: 50%;
   box-shadow: inset 0px 1px 1px black, 0px 1px 0px rgba(255, 255, 255, 0.9);
 }

</style>
	<div class="main-panel">
			<div class="content">
				<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Notification</h4>
						<ul class="breadcrumbs">
							<li class="nav-home">
								<a href="#">
									<i class="flaticon-home"></i>
								</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="{{url('notification')}}">Notification</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="#">Send Notification</a>
							</li>
						</ul>
					</div>
					<div class="row">
						

						

						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="d-flex align-items-center pull-right">
									<!-- <a href="{{url('users/create')}}" class="btn btn-secondary pull-right">
											<span class="btn-label">
												<i class="fa fa-plus"></i>
											</span>
											Create User
										</a>	-->
										
									</div>
								</div>
								<div class="card-body">
								@if(session('message'))
				<p class="alert alert-success">{{session('message')}}</p>
			@endif
									
									<form method="post" action="{{url('send-notification-users')}}" id="exampleValidation" novalidate="novalidate" enctype="multipart/form-data" >
									@csrf
									<div class="card-body">
									<div class="form-group form-show-validation row">
										<label for="description" class="col-lg-2 ">Description <span class="required-label">*</span></label>
										<div class="col-lg-6">
										<textarea rows="3"  cols="3" type="text" class="form-control" id="editor1" name="description" placeholder="Description to send notification to all users" value="{{old('description')}}"></textarea>
																		
										</div>
									</div>
									<div class="form-group form-show-validation row">
										<label for="image" class="col-lg-2 ">Image </label>
										<div class="col-lg-6">
										<input class="form-control" name="image" id="image" type="file" />
										<div class="text-danger"></div>
										</div>
										<div class="col-lg-2" >
										<img style="display:none;"  id="image_thumb" src="" width="50" />
										</div>
									</div>
																
									</div>
									<div class="col-lg-2">
										<button type="submit" name="submit" class="btn btn-block btn-danger">Submit</button>
									</div>
								</form>

								
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
		</div>	
		<!-------------------Modal Start----------------->	
			  <div class="container"> 
                        
                        <!-- Trigger the modal with a button --> 
                        
<!-- Modal -->

<div class="modal fade" id="view_modal" role="dialog">
	<div class="modal-dialog modal-lg">		
	<!-- Modal content-->
	<div class="modal-content">
	<div class="modal-header">
	<h4 class="modal-title">Users Details</h4>
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	
	</div>
    <div class="modal-body view_body">
       
    </div>
   <div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>

</div>
                          </div>
                                </div>
</div>
	<!-------------------Modal End----------------->
		
		<script>
		$(document).ready(function(){
			  $("#exampleValidation").validate({
			validClass: "success",
			rules: {
				description: {
					required: true
				},
				
			},
			
			highlight: function(element) {
				$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
			},
			success: function(element) {
				$(element).closest('.form-group').removeClass('has-error').addClass('has-success');
			},
		});
		
		$(".delete_user").click(function(e){
    e.preventDefault();
	var id = $(this).attr('id');
	 bootbox.confirm({
		  message:"Are you sure you want to delete this user?",
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
		// For view transaction //For view order Details
	$(".view").click(function(e){
		e.preventDefault();
		$("#view_modal").modal();
	  var transaction_id = $(this).attr('id');
	 
	  var url =  $(this).attr('href');
	  
	  $.ajax({
		  url:url,
		  data:{id:transaction_id},
		  type:"get",
		  success:function(data)
		  {
			  $(".view_body").html(data);
		  }
	  })
  });
   function readURL(input) 
	{
		if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function(e) {
		$('#image_thumb').attr('src', e.target.result);

		$('#image_thumb').hide();
		$('#image_thumb').fadeIn(650);
		}
	   reader.readAsDataURL(input.files[0]);
		}
	}

	$("#image").change(function() {
	readURL(this);
	}); 
		});

	</script>
		
@endsection	