@extends('layouts.admin')
@section('title','Lottery')
@section('content')
 <!-- Start Bottom Header -->
 <div class="page-area">
            <div class="breadcumb-overlay"></div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="breadcrumb text-center">
                            <div class="section-headline text-center">
                                <h3>Order</h3>
                            </div>
                            <ul>
                                <li class="home-bread">Home</li>
                                <li>Order</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Header -->
  <!-- Start Number area -->
  <div class="lottery-area area-padding-2">
            <div class="container">
                 <div class="row">
				 @if(session('message'))
				<p class="alert alert-success">{{session('message')}}</p>
			@endif
					
				</div>
                 <div class="row">
                    <div class="lottery-content">
                      <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="deposite-content">
                            <div class="diposite-box">
                                <div class="deposite-table">
                                    <table>
                                        <tr>
                                            <th style="height:10px;">Sr No</th>
													<th>Order Id</th>
													<th>Price</th>
													<th style="width: 130px !important;">Date</th>
													<th style="width: 85px;">Status</th>
													<th >Action</th>
                                        </tr>
                                        <?php $i=1;?>
										@foreach($orders as $order)
										@if($order->status=="complete")

										<?php $order_stats_txt_new = "<span style='float:left;padding:1px 9px;font-size:16px;'  class='text-success'><i class='fa fa-check' aria-hidden='true'></i> Complete</span>";
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
                                    </table>
                                </div>
								
                            </div>
							 {{ $orders->appends(request()->query())->links() }}
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
	<input type="hidden" name="user_id" id="user_id" value="@if(Auth::check()){{Auth::user()->id}}@else 0 @endif" />
	
        <!-- End Number area -->	
		
		<!-- jquery latest version -->
		<script src="{{url('public/frontend/js/vendor/jquery-1.12.4.min.js')}}"></script>
		<script>
		function submit()
		{
			$("form").submit();
		}
		
		
		$(document).ready(function(){
			$(".dd").change(function(){
				submit();
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
		})
		</script>
		
@endsection	