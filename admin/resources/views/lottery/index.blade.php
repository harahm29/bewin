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
								<a href="#">List</a>
							</li>
						</ul>
					</div>
					<div class="row">
						

						

						<div class="col-md-12">
							<div class="card">
								<div class="card-header"> 
									<div class="box-header" align="right">
									<a  align="right" href="{{url('match-code')}}" class="btn btn-success btn-sm" data-toggle="tooltip" title="Lottery Draw" ><b>  Lottery Draw</b></a>
									<a  align="right" href="{{url('lottery/create')}}" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Add Lottery" ><b><i class="fa fa-plus" aria-hidden="true"></i> Add Lottery</b></a>

									</div> 
								</div>
								<div class="card-body">
								@if(session('message'))
								<p class="alert alert-success">{{session('message')}}</p>
								@endif
								<div class="table-responsive">
										<table width="100%" id="example1" class="display table table-striped table-hover" style="width:500px;" >

										<thead>
										<tr>
										<th>Id</th>
										<th>Lottery Name</th>
										<th>Created</th>
										<th>Validity</th>
										<th>Expiry Date</th>
										<th>Draw Days</th>
										<th>Ticket Price</th>
										
										<th>Action</th>
										</tr>
										</thead>


										<tbody>
										<tr>
										@php $i=1; @endphp
											@foreach($lotterys as $lottery)
												   <td>{{$i}}</td>
												   <td>{{$lottery->name}}</td>
												   <td >{{date('d-m-Y',strtotime($lottery->created_at))}} </td>
												   <td >{{date('d-m-Y',strtotime($lottery->validity))}} </td>
												   <td >@if($lottery->expire_date != ''){{date('d-m-Y',strtotime($lottery->expire_date))}} @endif </td>
												    <td><?php echo wordwrap($lottery->draw_days,18,'<br />', true) ?></td>
												   <td>{{($lottery->ticket_price)}}</td>
												   <td> 
												   <form method="post" id="delete_form_{{$lottery->id}}" action="{{url('lottery/'.$lottery->id)}}"  style="width:150px;">
													@method('DELETE')
													@csrf
												<input type="hidden" name="id" id="id" value="{{$lottery->id}}" />
											
												<button type="button" id="{{$lottery->id}}" href="{{url('lottery/'.$lottery->id)}}"  class="view btn btn-sm btn-info view" data-toggle="tooltip" title="View">	<i class="fa fa-eye" aria-hidden="true"></i></button> 
												
												  <a href="{{url('lottery/'.$lottery->id.'/edit')}}" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
												  
												  <button type="submit" id="{{$lottery->id}}" class="btn btn-sm btn-danger delete" data-toggle="tooltip" title="Delete" ><i class="fa fa-trash" aria-hidden="true"></i></button>
												</td>
											</tr>
											 </form> 
										 <?php $i++; ?>
														@endforeach

										<?php 
										// echo count($data11);
										// echo "<pre>";
										// print_r($data11);
										?>

										</tbody>
										</table>
									</div>	
									

								
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
	<div class="modal-header bg-success" style="color:#fff;">
 <h4 class="modal-title"><i class="fas fa-info-circle"></i> Lottery Details</h4>
<button type="button" class="close" data-dismiss="modal">&times;</button>
   
</div>
    <div class="modal-body view_body" align="center">
       
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
		
	
		// For view transaction //For view order Details
	
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