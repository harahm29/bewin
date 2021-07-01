@extends('layouts.admin')
@section('title','Term And Condition Edit')
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
						<h4 class="page-title">Term And Condition</h4>
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
								<a href="{{url('termandcondition')}}">Term And Condition</a>
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
									<a align="right" href="{{url('termandcondition')}}" class="btn btn-primary btn-sm" data-toggle="tooltip" title="All Term And Condition" ><b><i class="fa fa-list" aria-hidden="true"></i> All Term And Condition</b></a>

									</div> 
								</div>
								<div class="card-body">
								@if(session('message'))
									<p class="alert alert-success">{{session('message')}}</p>
								@endif
									
									<form method="post" action="{{url('termandcondition/'.$termandcondition->id)}}" id="exampleValidation" novalidate="novalidate" enctype="multipart/form-data" >
									@csrf
									@method("PUT")
									<div class="card-body">
									<div class="form-group form-show-validation row">
										<label for="content" class="col-lg-3 ">Content </label>
										<div class="col-lg-9">
										<textarea  type="text" class="form-control" id="editor" name="content" placeholder="Content Area" value="{{$termandcondition->content}}" required >{{$termandcondition->content}}</textarea>
										<div class="text-danger">{{$errors->first('content')}}</div>							
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
		CKEDITOR.replace('editor');
		
			
		
	
		});

	</script>
		
@endsection	