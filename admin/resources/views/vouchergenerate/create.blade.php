@extends('layouts.admin')
@section('title','Create Voucher')
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
						<h4 class="page-title">Voucher</h4>
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
								<a href="{{url('voucher-Generate')}}">Voucher</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="#">Create Voucher</a>
							</li>
						</ul>
					</div>
					<div class="row">
						

						

						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="box-header" align="right">
									<a align="right" href="{{url('voucher-Generate')}}" class="btn btn-primary btn-sm" data-toggle="tooltip" title="All Voucher" ><b><i class="fa fa-list" aria-hidden="true"></i> All Voucher</b></a>

									</div> 
								</div>
								<div class="card-body">
								@if(session('message'))
									<p class="alert alert-success">{{session('message')}}</p>
								@endif
									
									<form method="post" action="{{url('voucher-Generate')}}" id="exampleValidation" novalidate="novalidate">
									@csrf
									<div class="card-body">
								
									<div class="form-group form-show-validation row">
										<label for="amount" class="col-lg-3 ">Agent <span class="required-label">*</span></label>
										<div class="col-lg-6">
										<select class="form-control numeric_feild select2" id="agent_id" name="agent_id" placeholder="Agent Name" value="{{old('agent_id')}}" required />
										 <option value="">Select Agent</option>
										 @foreach($users as $user)
										 <option value="{{$user->id}}">{{$user->first_name}}</option>
										 @endforeach
										</select>
																
										</div>
									</div>
									<div class="form-group form-show-validation row">
										<label for="amount" class="col-lg-3 ">Amount <span class="required-label">*</span></label>
										<div class="col-lg-6">
										<input  type="text" class="form-control numeric_feild" id="amount" name="amount" placeholder="Amount" value="{{old('amount')}}" required />
										<div class="text-danger">{{$errors->first('amount')}}</div>							
										</div>
									</div>
									
									<div class="form-group form-show-validation row">
										<label for="voucher_number" class="col-lg-3 ">Voucher Number <span class="required-label">*</span></label>
										<div class="col-lg-6">
										<input class="form-control numeric_feild" name="voucher_number" id="voucher_number" type="text" placeholder="Voucher Number" />
										<div class="text-danger">{{$errors->first('voucher_number')}}</div>
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
				amount: {
					required: true
				},
				voucher_number: {
					required: true,
					number:true
				},
				
			},
			
			highlight: function(element) {
				$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
			},
			success: function(element) {
				$(element).closest('.form-group').removeClass('has-error').addClass('has-success');
			},
		});
		
	
		});

	</script>
		
@endsection	