            
			<!-------model Decline-->
                              <div class="container"> 
                        
                        <!-- Trigger the modal with a button --> 
                        
                        <!-- Modal -->
						<div class="modal fade" id="declined_model{{$order->order_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		<form method="get" action="{{url('update-order-status/'.$order->order_id.'/'.$order->user_id.'/canceled')}}">
			<div class="modal-header">
				<h5 style="color:#000;font-weight:bold;" class="modal-title" id="exampleModalLongTitle">Cancel Order</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
       <div class="form-group form-show-validation row">
          <p style="color:#000;font-weight:bold;" for="comment">Reason for cancellation:</p>
			
            <textarea name="comment" class="form-control form-control-file" rows="5" id="comment" required ></textarea>
        </div>
    </div>
    <div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-success">Save changes</button>
			</div>	
</form>
                                    </div>
                          </div>
                                </div>
                      </div>
<!-------model Received---->
<div class="container">
<!-- Trigger the modal with a button -->
<!-- Modal -->

	
	<form method="post" action="{{url('update-order-status')}}" enctype="multipart/form-data" >
	@csrf
	<div class="modal fade" id="received_model{{$order->order_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 style="color:#000;font-weight:bold;" class="modal-title" id="exampleModalLongTitle">Shipping Order</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
	
	
		<div class="form-group form-show-validation row">
			
			<p style="color:#000;font-weight:bold;" for="tracking_details" >Tracking Id: <span class="required-label">*</span></p>
				<input type="text" name="tracking_id" class="form-control form-control-file"  id="tracking_details" required />
		</div>
		<div class="form-group form-show-validation row">
		<p style="color:#000;font-weight:bold;" for="shipping_details" class="">Shipping Details: <span class="required-label">*</span></p>
		
		<input name="billing_email" type="hidden" value="<?php //echo  $billing_email;?>" />
		<textarea name="shipping_details" class="form-control form-control-file"  id="shipping_details" required></textarea>
		</div>
		<div class="form-group form-show-validation row">
		<p style="color:#000;font-weight:bold;" for="comment">Delivery Proof:</p>
		<input type="hidden" name="order_status" value="shipped" />
		<input type="hidden" name="order_id" value="{{$order->order_id}}" />
		<input type="hidden" name="user_id" value="{{$order->user_id}}" />
		<input type="file" name="delivery_proof" class="form-control form-control-file"  id="delivery_proof" />
		</div>
	</div>
	<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-success">Save changes</button>
			</div>									
	
	</form>
    </div>
	</div>
	</div>
									  
	</div>
									<!-------Model Shipping-->
<div class="container">
	  
	  <!-- Trigger the modal with a button -->
	  
	  <!-- Modal -->
	<div class="modal fade" id="shipped_model{{$order->order_id}}" role="dialog">
	<div class="modal-dialog">		
	<!-- Modal content-->
	<div class="modal-content">
	<div class="modal-header">
	<form method="post" action="{{url('update-order-status')}}" enctype="multipart/form-data" >
	@csrf
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title">Delivery Details</h4>
	</div>
	<div class="modal-body">
	<div class="form-group form-show-validation row">
	<p style="color:#000;font-weight:bold;" for="comment">Delivery Proof:</p>
	<input type="hidden" name="order_status" value="delivered" />
	<input type="hidden" name="order_id" value="{{$order->order_id}}" />
	<input type="hidden" name="user_id" value="{{$order->user_id}}" />
	<input type="file" name="delivery_proof" class="form-control form-control-file"  id="delivery_proof" />
	</div>
	<div class="form-group form-show-validation row">
	<p style="color:#000;font-weight:bold;" for="comment">Additional Details:</p>
	<textarea name="additional_details" class="form-control form-control-file" rows="5" id="additional_details" required></textarea>
												
	</div>
	</div>
	<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-success">Save changes</button>
			</div>
	</form>
	</div>
	</div>
	</div>
	</div>