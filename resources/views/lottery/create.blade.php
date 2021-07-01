@extends('layouts.admin')
@section('title','Lottery Create')
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
						<h4 class="page-title">Lottery</h4>
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
								<a href="{{url('lottery')}}">Lottery</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="#">Create</a>
							</li>
						</ul>
					</div>
					<div class="row">
						

						

						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="box-header" align="right">
									<a align="right" href="{{url('lottery')}}" class="btn btn-primary btn-sm" data-toggle="tooltip" title="All Lottery" ><b><i class="fa fa-list" aria-hidden="true"></i> All Lottery</b></a>

									</div> 
								</div>
								<div class="card-body">
								@if(session('message'))
				<p class="alert alert-success">{{session('message')}}</p>
			@endif
									
									<form method="post" action="{{url('lottery')}}" id="exampleValidation" novalidate="novalidate" enctype="multipart/form-data" >
									@csrf
									<div class="card-body">
									<div class="form-group form-show-validation row">
										<label for="name" class="col-lg-3 ">Lottery name <span class="required-label">*</span></label>
										<div class="col-lg-6">
										<input  type="text" class="form-control" id="name" name="name" placeholder="Lottery Name" value="{{old('name')}}">
																		
										</div>
									</div>
									<div class="form-group form-show-validation row">
										<label for="image" class="col-lg-3 ">Banner/Image </label>
										<div class="col-lg-6">
										<input class="form-control" name="image" id="image" type="file" />
										<div class="text-danger"></div>
										</div>
										<div class="col-lg-2" >
										<img style="display:none;"  id="image_thumb" src="" width="50" />
										</div>
									</div>
									<fieldset>
									<legend style="font-size:14px;font-weight:bold;">Value Categories<hr></legend>
									</fieldset>
									
									<div class="form-group form-show-validation row">
										<label for="cat1_val" class="col-lg-3 "> </label>
										<div class="col-lg-6">
										<label > Values </label>
										</div>
										<div class="col-lg-2" >
										<label > Max no of winners </label>
										</div>
									</div>
									<div class="form-group form-show-validation row">
										<label for="cat1_val" class="col-lg-3 ">Category 1 (6+power ball)  </label>
										<div class="col-lg-6">
										<input  type="text" class="form-control" id="cat1_val" name="cat1_val" placeholder="" value="{{old('cat1_val')}}">
										<div class="text-danger"></div>
										</div>
										<div class="col-lg-2" >
										<input  type="text" class="form-control" id="cat1_max_winner" name="cat1_max_winner" placeholder="" value="{{old('cat1_max_winner')}}">
										</div>
									</div>
										<div class="form-group form-show-validation row">
										<label for="cat2_val" class="col-lg-3 ">Category 2 (6 of 6)  </label>
										<div class="col-lg-6">
										<input  type="text" class="form-control" id="cat2_val" name="cat2_val" placeholder="" value="{{old('cat2_val')}}">
										<div class="text-danger"></div>
										</div>
										<div class="col-lg-2" >
										<input  type="text" class="form-control" id="cat2_max_winner" name="cat2_max_winner" placeholder="" value="{{old('cat2_max_winner')}}">
										</div>
									</div>
										<div class="form-group form-show-validation row">
										<label for="cat3_val" class="col-lg-3 ">Category 3 (5+power ball)  </label>
										<div class="col-lg-6">
										<input  type="text" class="form-control" id="cat3_val" name="cat3_val" placeholder="" value="{{old('cat3_val')}}">
										<div class="text-danger"></div>
										</div>
										<div class="col-lg-2" >
										<input  type="text" class="form-control" id="cat3_max_winner" name="cat3_max_winner" placeholder="" value="{{old('cat3_max_winner')}}">
										</div>
									</div>
										<div class="form-group form-show-validation row">
										<label for="cat4_val" class="col-lg-3 ">Category 4 (5 of 6)  </label>
										<div class="col-lg-6">
										<input  type="text" class="form-control" id="cat4_val" name="cat4_val" placeholder="" value="{{old('cat4_val')}}">
										<div class="text-danger"></div>
										</div>
										<div class="col-lg-2" >
										<input  type="text" class="form-control" id="cat4_max_winner" name="cat4_max_winner" placeholder="" value="{{old('cat4_max_winner')}}">
										</div>
									</div>
										<div class="form-group form-show-validation row">
										<label for="cat5_val" class="col-lg-3 ">Category 5 (4+power ball)  </label>
										<div class="col-lg-6">
										<input  type="text" class="form-control" id="cat5_val" name="cat5_val" placeholder="" value="{{old('cat5_val')}}">
										<div class="text-danger"></div>
										</div>
										<div class="col-lg-2" >
										<input  type="text" class="form-control" id="cat5_max_winner" name="cat5_max_winner" placeholder="" value="{{old('cat5_max_winner')}}">
										</div>
									</div>
										<div class="form-group form-show-validation row">
										<label for="cat6_val" class="col-lg-3 ">Category 6 (4 of 6)  </label>
										<div class="col-lg-6">
										<input  type="text" class="form-control" id="cat6_val" name="cat6_val" placeholder="" value="{{old('cat6_val')}}">
										<div class="text-danger"></div>
										</div>
										<div class="col-lg-2" >
										<input  type="text" class="form-control" id="cat6_max_winner" name="cat6_max_winner" placeholder="" value="{{old('cat6_max_winner')}}">
										</div>
									</div>
										<div class="form-group form-show-validation row">
										<label for="cat7_val" class="col-lg-3 ">Category 7 (3+power ball)  </label>
										<div class="col-lg-6">
										<input  type="text" class="form-control" id="cat7_val" name="cat7_val" placeholder="" value="{{old('cat7_val')}}">
										<div class="text-danger"></div>
										</div>
										<div class="col-lg-2" >
										<input  type="text" class="form-control" id="cat7_max_winner" name="cat7_max_winner" placeholder="" value="{{old('cat7_max_winner')}}">
										</div>
									</div>
										<div class="form-group form-show-validation row">
										<label for="cat8_val" class="col-lg-3 ">Category 8 (3 of 6)  </label>
										<div class="col-lg-6">
										<input  type="text" class="form-control" id="cat8_val" name="cat8_val" placeholder="" value="{{old('cat8_val')}}">
										<div class="text-danger"></div>
										</div>
										<div class="col-lg-2" >
										<input  type="text" class="form-control" id="cat8_max_winner" name="cat8_max_winner" placeholder="" value="{{old('cat8_max_winner')}}">
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
		
		
		<script>
		$(document).ready(function(){
			  $("#exampleValidation").validate({
			validClass: "success",
			rules: {
				name: {
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