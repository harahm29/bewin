@extends('layouts.admin')
@section('title','Lottery Content')
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
						<h4 class="page-title">Lottery Content</h4>
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
								<a href="{{url('lottery-Content')}}">Lottery Content</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="#">Edit</a>
							</li>
						</ul>
					</div>
					<div class="row">
						

						

						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="box-header" align="right">
									<a align="right" href="{{url('lottery-Content')}}" class="btn btn-primary btn-sm" data-toggle="tooltip" title="All Lottery" ><b><i class="fa fa-list" aria-hidden="true"></i> Lottery Content</b></a>

									</div> 
								</div>
								<div class="card-body">
								@if(session('message'))
				<p class="alert alert-success">{{session('message')}}</p>
			@endif
									
									<form method="post" action="{{url('lottery-Content/'.$lotteryContent->id)}}" id="exampleValidation" novalidate="novalidate" >
									@csrf
									@method('PUT')
									<div class="card-body">
									<div class="form-group form-show-validation row">
										<label for="name" class="col-lg-3 ">Lottery Content <span class="required-label">*</span></label>
										<div class="col-lg-6">
										<input  type="text" class="form-control" id="lottery_content" name="lottery_content" placeholder="Lottery Content" value="{{$lotteryContent->lottery_content}}">
										<div class="text-danger">{{$errors->first('lottery_content')}}</div>							
										</div>
									</div>
									<div class="form-group form-show-validation row">
										<label for="image" class="col-lg-3 ">Lottery Content Description</label>
										<div class="col-lg-6">
										<textarea class="form-control" name="lottery_content_des" id="lottery_content_des">{{$lotteryContent->lottery_content_des}}</textarea>
										<div class="text-danger"></div>
										</div>
										
									</div>							
									</div>
								</div>
								<div class="card-action">
									<button type="submit" class="btn btn-success">Submit</button>
									<a href="{{url('lottery-Content')}}" class="btn btn-danger">Cancel</a>
								</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			
		</div>	
		<script src="//cdn.gaic.com/cdn/ui-bootstrap/0.58.0/js/lib/ckeditor/ckeditor.js"></script>
 
  <script src="//cdn.gaic.com/cdn/ui-bootstrap/0.58.0/js/lib/angular.min.js"></script>
		
		<script>
		$(function() {
		  $(".datepicker").datepicker({ 
				autoclose: true, 
				todayHighlight: true
		  });
		});
		function all_check_auto()
		{
			var check_length = $(".draw_day:checked").length;
			
			
			if(check_length==7)
			{
				$("#all_check").prop("checked",true);
			}
			else
			{
				$("#all_check").prop("checked",false);
			}
		}
		$(document).ready(function(){
			all_check_auto();
			 $("#all_check").click(function(){
			
			var val = $("#all_check:checked").val();
			console.log(val);
			if(val=="all_check")
			{
				$(".draw_day").each(function(){
					$(this).prop("checked",true);
				});
			}
			else
			{
				$(".draw_day").each(function(){
				$(this).prop("checked",false);
			});
			}
			});
			
			$(".draw_day").click(function(){
			all_check_auto();
			
		});
		
		$.validator.addMethod("greaterThan",
			function (value, element, param) {
				  var $otherElement = $(param);
				  return parseInt(value, 10) > parseInt($otherElement.val(), 10);
			});
		$.validator.addMethod("lessThan",
			function (value, element, param) {
				  var $otherElement = $(param);
				  return parseInt(value, 10) < parseInt($otherElement.val(), 10);
			});
		
			  $("#exampleValidation").validate({
			validClass: "success",
			rules: {
				lottery_content: {
					required: true
				},
				lottery_content_des: {
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
//////
CKEDITOR.editorConfig = function (config) {
			config.language = 'es';
			config.uiColor = '#F7B42C';
			config.height = 300;
			config.toolbarCanCollapse = true;

		};
		CKEDITOR.replace('lottery_content_des');
	</script>
		
@endsection	