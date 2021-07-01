@extends('layouts.admin')
@section('title',"Agent History")
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
						<h4 class="page-title">Agent History</h4>
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
								<a href="{{url('users')}}">Agent History</a>
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
									<div class="box-header" align="right"><h2 style="float:left;">{{$user->first_name ?? ""}} {{$user->last_name ?? ""}}</h2>
									<a  align="right" href="{{url('agent')}}" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Back" ><b><i class="fa fa-backspace" aria-hidden="true"></i> Back</b></a>

									</div> 
								</div>
								<div class="card-body">
								@if(session('message'))
				<p class="alert alert-success">{{session('message')}}</p>
			@endif
									

									<div class="table-responsive">
										<table id="example1" class="display table table-striped table-hover"  >

										<thead>
										<tr>
										<th>SrNo</th>
										<th>Date</th>
										<th>Plan</th>
										<th>Total no of Codes</th>
										<th>Total Value</th>
										<th>Action</th>
										</tr>
										</thead>

										<tbody>
										
										@php $i=1; 
										function get_voucher_names($id,$today_date)
										{
											$plan_names =  DB::table("codes")->select(DB::raw("vs.name as voucher_name"))
														->leftjoin("vouchers as vs",function($join){
															$join->on("vs.id","=","codes.voucher_id");
														})
														->where(['codes.is_deleted'=>0,'codes.user_id'=>$id,'codes.today_date'=>$today_date])
														->pluck('voucher_name')->toarray();
											return $plan_name = implode(",",$plan_names);
										}
										@endphp
											@foreach($codes as $code)
											
											<tr>
												   <td>{{$i}}</td>
												   <td>{{date("d-M-Y",strtotime($code->today_date))}}</td>
												   <td >{{get_voucher_names($code->user_id,$code->today_date)}}</td>
												   <td >{{$code->total_code}}</td>
												   <td >{{$code->total_value}}</td>
												   <td> 
												    <a type="button" id="{{$code->id}}" href="{{url('agent-code-listing/'.$code->today_date.'/'.$code->user_id)}}"  class="btn btn-sm btn-info"data-toggle="tooltip" title="View">	<i class="fa fa-eye" aria-hidden="true"></i></a>  
												   </td>
											</tr>
											 
										 @php $i++; @endphp
											@endforeach


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
						 <h4 class="modal-title"><i class="fas fa-info-circle"></i> Personal Information</h4>
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
		});

	</script>
		
@endsection	