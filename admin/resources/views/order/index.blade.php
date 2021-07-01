@extends('layouts.admin')
@section('title','Orders')
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
						<h4 class="page-title">Orders</h4>
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
								<a href="{{url('orders')}}">Orders</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="#">All orders</a>
							</li>
						</ul>
					</div>
					<div class="row">
						

						

						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="d-flex align-items-center pull-right">
										
										
									</div>
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
													<th>Order Id</th>
													<th>Price</th>
													<th>Name</th>
													<th style="width: 130px !important;">Date</th>
													<th style="width: 85px;">Status</th>
													<th >Action</th>
												</tr>
											</thead>
											
											<tbody>							
<?php $i=1;?>
@foreach($orders as $order)
@if($order->status=="complete")

<?php $order_stats_txt_new = "<span  class='text-success'><i class='fa fa-check' aria-hidden='true'></i> Complete</span>";
 ?>
@elseif($order->status=="pending")

<?php $order_stats_txt_new = "<span class='text-warning'><i class='fa fa-clock-o' aria-hidden='true'></i> Pending</span>"; ?>

@elseif($order->status=="failed")

<?php $order_stats_txt_new = '<span class="text-danger"><i class="fa fa-times" aria-hidden="true"></i> Failed</span>'; ?>

@endif       
@include('order.model_orders')
											
												<tr>
													<td>{{$i}}</td>
													<td>{{$order->order_id}}</td>
													<td>{{$order->price}}</td>
													<td>{{$order->name}}</td>
													<td>{{date("d-m-Y",strtotime($order->created_at))}}</td>
													<td><?php echo $order_stats_txt_new;?></td>
													<td>
													<form id="delete_form_{{$order->id}}" method="post" action="{{url('order/'.$order->id)}}" >
													@csrf
													@method('DELETE')
														<div class="form-button-action">
															<button url="{{url('order/'.$order->id)}}" data-toggle="tooltip" title="" class="btn btn-warning view btn-sm" data-original-title="View Order">
																<i class="fa fa-eye"></i>
															</button>&nbsp;&nbsp;
															
															
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
<div class="modal-header">
 <h4 class="modal-title">Order Details</h4> 
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
			$(".shipping").click(function(e){
				e.preventDefault();
				var target = $(this).attr('id');
				
				$(target).modal();
			});
			$(".cancel").click(function(e){
				e.preventDefault();
				var target = $(this).attr('id');
				
				$(target).modal();
			});
			$(".delivery").click(function(e){
				e.preventDefault();
				var target = $(this).attr('id');
				$(target).modal();
			});
		$(".delete_order").click(function(e){
    e.preventDefault();
	var id = $(this).attr('id');
	 bootbox.confirm({
		  message:"Are you sure you want to delete this order?",
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
		//For view order Details
	$(".view").click(function(e){
		e.preventDefault();
		$("#view_modal").modal();
		$(".view_body").html('');
	  var order_id = $(this).attr('id');
	 
	  var url =  $(this).attr('url');
	  $.ajax({
		  url:url,
		  data:{order_id:order_id},
		  type:"get",
		  success:function(data)
		  {
			  $(".view_body").html(data);
		  }
	  })
  });
  
  //For Accept Order 
  $(".pending").click(function(e){
    e.preventDefault();
	var id = $(this).attr('id');
	 bootbox.confirm({
		  message:"Are you sure you want confirm this order?",
		  buttons:{ cancel: {
            label: '<i class="fa fa-times"></i> Cancel'
			},
			confirm: {
				label: '<i class="fa fa-check"></i> Confirm'
			},
			  },
		    callback: function (result) {
				if(result){
				var href = $(".pending").attr('href');
				location.href=href;		
			  
				}
			}
		  })//confirm
 });
		});

	</script>
		
@endsection	