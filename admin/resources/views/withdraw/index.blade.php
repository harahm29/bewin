@extends('layouts.admin')
@section('title','Withdraw')
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
						<h4 class="page-title">Withdraw</h4>
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
								<a href="{{url('withdraw')}}">Withdraw</a>
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
									<!--<div class="d-flex align-items-center pull-right">
									 <a href="{{url('withdraw/create')}}" class="btn btn-primary pull-right btn-sm" data-toggle="tooltip" title="Create Voucher">
											<span class="btn-label">
												<i class="fa fa-plus"></i>
											</span>
											Create Voucher
									</a>	
										
									</div>-->
								</div>
								<div class="card-body">
								@if(session('message'))
				<p class="alert alert-success">{{session('message')}}</p>
			@endif
									

									<div class="table-responsive">
										<table id="example1" class="display table table-striped table-hover" >
											<thead>
												<tr>
													<th>Sr No</th>
													<th>Amount</th>
													<th>Type</th>
													<th>Paypal Id</th>
													<th>Date</th>
													<th>Status</th>
													<th >Action</th>
												</tr>
											</thead>
											
											<tbody>
											@php $i=1; @endphp
											@foreach($withdraws as $withdraw)
											@php
											if($withdraw->status==1)
											$status ='<p class="text-success" ><i class="fas fa-check"></i> Approved</p>';
											else if($withdraw->status==2)
												$status ='<p class="text-danger" ><i class="fas fa-times"></i> Canceled</p>';
											else if($withdraw->status==0)
											$status ='<p class="text-warning" ><i class="fas fa-clock"></i> Pending</p>';
											@endphp
												<tr>
													<td>{{$i}}</td>
												   <td>${{$withdraw->amount}}</td>
												   <td>{{ucfirst($withdraw->type)}}</td>
												   <td>{{$withdraw->paypal_id}}</td>
												   <td >{{date('d-M-Y',strtotime($withdraw->today_date))}}</td>
												   <td ><?= $status; ?></td>
													<td>
													<form id="delete_form_{{$withdraw->id}}" method="post" action="{{url('withdraw/'.$withdraw->id)}}" >
													@csrf
													@method('DELETE')
														<div class="form-button-action">
														<a href="{{url('withdraw/'.$withdraw->id)}}" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg view" data-original-title="View">
																<i class="fa fa-eye"></i>
															</a>
														<a href="{{url('approve-withdraw-request/'.$withdraw->id)}}" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg withdraw @if($withdraw->status==1 || $withdraw->status==2 ) disabled @endif " data-original-title="Approve Request">
																<i class="fa fa-check"></i>
															</a>
															
												
															<button id="{{$withdraw->id}}" type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger delete_request @if($withdraw->status==1 || $withdraw->status==2 ) disabled @endif" data-original-title="Cancel Request">
																<i class="fa fa-times"></i>
															</button>
														</div>
														</form>
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
 <h4 class="modal-title"><i class="fas fa-info-circle"></i> Withdraw Details</h4>
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
		$(".withdraw").click(function(e){
		e.preventDefault();
		var id = $(this).attr('id');
		var href = $(this).attr('href');
		 bootbox.confirm({
		  message:"Are you sure you want to approve this withdraw request?",
		  buttons:{ cancel: {
            label: '<i class="fa fa-times"></i> Cancel'
			},
			confirm: {
				label: '<i class="fa fa-check"></i> Confirm'
			},
			  },
		    callback: function (result) {
				if(result){
						
			 location.href = href;
				}
			}
		  })//confirm
		});
		$(".delete_request").click(function(e){
		e.preventDefault();
		var id = $(this).attr('id');
		 bootbox.confirm({
		  message:"Are you sure you want to cancel this withdraw request?",
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
		
		
		});

	</script>
		
@endsection	