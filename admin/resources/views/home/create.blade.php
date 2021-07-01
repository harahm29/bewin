@extends('layouts.admin')
@section('title','Home Create')
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
						<h4 class="page-title">Home</h4>
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
								<a href="{{url('home')}}">Home</a>
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
									<a align="right" href="{{url('home')}}" class="btn btn-primary btn-sm" data-toggle="tooltip" title="All Home" ><b><i class="fa fa-list" aria-hidden="true"></i> All Home</b></a>

									</div> 
								</div>
								<div class="card-body">
								@if(session('message'))
									<p class="alert alert-success">{{session('message')}}</p>
								@endif
									
									<form method="post" action="{{url('home')}}" id="exampleValidation" novalidate="novalidate" enctype="multipart/form-data" >
									@csrf
									<div class="card-body">
									<div class="form-group form-show-validation row">
										<label for="banner_text" class="col-lg-3 ">Banner Text</label>
										<div class="col-lg-9">
										<textarea  type="text" class="form-control" id="banner_text" name="banner_text" placeholder="Banner Text" value="{{old('banner_text')}}" required ></textarea>
										<div class="text-danger">{{$errors->first('banner_text')}}</div>							
										</div>
									</div>
									<div class="form-group form-show-validation row">
											<label for="banner_image" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 ">Banner Image</label>
											<div class="col-lg-4 ">
												<input type="file" class="form-control form-control-file" name="banner_image" id="banner_image" placeholder="Photo" >
											</div>
											<div class="col-lg-4">
											<img style="display:none;"  id="banner_image_preview"  src="" width="70" class="pull-right" alt="User Image">
											</div>
									</div>
									<div class="form-group form-show-validation row">
											<label for="how_to_start1_image" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 ">How to Start Image1</label>
											<div class="col-lg-4 ">
												<input type="file" class="form-control form-control-file" name="how_to_start1_image" id="how_to_start1_image" placeholder="Photo" >
											</div>
											<div class="col-lg-4">
											<img style="display:none;"  id="how_to_start1_image_preview"  src="" width="70" class="pull-right" alt="User Image">
											</div>
									</div>
									<div class="form-group form-show-validation row">
											<label for="how_to_start2_image" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 ">How to Start Image2</label>
											<div class="col-lg-4 ">
												<input type="file" class="form-control form-control-file" name="how_to_start2_image" id="how_to_start2_image" placeholder="Photo" >
											</div>
											<div class="col-lg-4">
											<img style="display:none;"  id="how_to_start2_image_preview"  src="" width="70" class="pull-right" alt="User Image">
											</div>
									</div>
									<div class="form-group form-show-validation row">
											<label for="how_to_start3_image" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 ">How to Start Image3</label>
											<div class="col-lg-4 ">
												<input type="file" class="form-control form-control-file" name="how_to_start3_image" id="how_to_start3_image" placeholder="Photo" >
											</div>
											<div class="col-lg-4">
											<img style="display:none;"  id="how_to_start3_image_preview"  src="" width="70" class="pull-right" alt="User Image">
											</div>
									</div>
									
									<div class="form-group form-show-validation row">
										<label for="how_to_start1" class="col-lg-3 ">How To Start 1 </label>
										<div class="col-lg-9">
										<textarea  type="text" class="form-control" id="how_to_start1" name="how_to_start1" placeholder="How To Start 1" value="{{old('how_to_start1')}}" required ></textarea>
										<div class="text-danger">{{$errors->first('how_to_start1')}}</div>							
										</div>
									</div>
									<div class="form-group form-show-validation row">
										<label for="how_to_start2" class="col-lg-3 ">How To Start 2 </label>
										<div class="col-lg-9">
										<textarea  type="text" class="form-control" id="how_to_start2" name="how_to_start2" placeholder="How To Start 2" value="{{old('how_to_start2')}}" required ></textarea>
										<div class="text-danger">{{$errors->first('how_to_start2')}}</div>							
										</div>
									</div>
									<div class="form-group form-show-validation row">
										<label for="how_to_start3" class="col-lg-3 ">How To Start 3 </label>
										<div class="col-lg-9">
										<textarea  type="text" class="form-control" id="how_to_start3" name="how_to_start3" placeholder="How To Start 3" value="{{old('how_to_start3')}}" required ></textarea>
										<div class="text-danger">{{$errors->first('how_to_start3')}}</div>							
										</div>
									</div>
									<div class="form-group form-show-validation row">
										<label for="how_to_start3" class="col-lg-3 ">Why Choose</label>
										<div class="col-lg-9">
							<input type="text" class="form-control" id="why_choose" name="why_choose" placeholder="Why Choose" value="{{old('why_choose')}}" required/>
										<div class="text-danger">{{$errors->first('how_to_start3')}}</div>							
										</div>
									</div>
									<div class="form-group form-show-validation row">
										<label for="how_to_start3" class="col-lg-3 ">Why Choose Description</label>
										<div class="col-lg-9">
										<textarea  type="text" class="form-control" id="why_choose1" name="why_choose1" placeholder="Why Choose Description" value="{{old('why_choose1')}}" required ></textarea>
										<div class="text-danger">{{$errors->first('why_choose1')}}</div>							
										</div>
									</div>
									
														
									</div>
									<div class="card-action">
									<button type="submit" class="btn btn-success">Submit</button>
									<button type="reset" class="btn btn-danger">Cancel</button>
									</div>
								</form>

								
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
		</div>	
		<script src="//cdn.gaic.com/cdn/ui-bootstrap/0.58.0/js/lib/ckeditor/ckeditor.js"></script>
 
  <script src="//cdn.gaic.com/cdn/ui-bootstrap/0.58.0/js/lib/angular.min.js"></script>
		
		<script>
	
 
  
		$(document).ready(function(){
			  CKEDITOR.editorConfig = function (config) {
			config.language = 'es';
			config.uiColor = '#F7B42C';
			config.height = 300;
			config.toolbarCanCollapse = true;

		};
		CKEDITOR.replace('banner_text');
		CKEDITOR.replace('how_to_start1');
		CKEDITOR.replace('how_to_start2');
		CKEDITOR.replace('how_to_start3');
		CKEDITOR.replace('why_choose1');
		
	function readURL(input) 
	{
		if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function(e) {
		$('#banner_image_preview').attr('src', e.target.result);

		$('#banner_image_preview').hide();
		$('#banner_image_preview').fadeIn(650);
		}
	   reader.readAsDataURL(input.files[0]);
		}
	}

	$("#banner_image").change(function() {
	readURL(this);
	}); 
	function readURL1(input) 
	{
		if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function(e) {
		$('#how_to_start1_image_preview').attr('src', e.target.result);

		$('#how_to_start1_image_preview').hide();
		$('#how_to_start1_image_preview').fadeIn(650);
		}
	   reader.readAsDataURL(input.files[0]);
		}
	}

	$("#how_to_start1_image").change(function() {
	readURL1(this);
	}); 
	function readURL2(input) 
	{
		if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function(e) {
		$('#how_to_start2_image_preview').attr('src', e.target.result);

		$('#how_to_start2_image_preview').hide();
		$('#how_to_start2_image_preview').fadeIn(650);
		}
	   reader.readAsDataURL(input.files[0]);
	   }
	}

	$("#how_to_start2_image").change(function() {
	readURL2(this);
	}); 
	function readURL3(input) 
	{
		if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function(e) {
		$('#how_to_start3_image_preview').attr('src', e.target.result);

		$('#how_to_start3_image_preview').hide();
		$('#how_to_start3_image_preview').fadeIn(650);
		}
	   reader.readAsDataURL(input.files[0]);
		}
	}

	$("#how_to_start3_image").change(function() {
	readURL3(this);
	}); 
	
		
	
		});

	</script>
		
@endsection	