@extends('layouts.admin')
@section('title','Lottery')
@section('content')
<style>
.error{
	color:red;
}
</style>
 <!-- Start Bottom Header -->
 <div class="page-area">
            <div class="breadcumb-overlay"></div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="breadcrumb text-center">
                            <div class="section-headline text-center">
                                <h3>Agent Code Purchase</h3>
                            </div>
                            <ul>
                                <li class="home-bread">Home</li>
                                <li>Agent Code Purchase</li>
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
			@if(session('error_message'))
				<p class="alert alert-danger">{{session('error_message')}}</p>
			@endif
					
				</div>
                 <div class="row">
                    <div class="lottery-content">
                 <table border="0"  class="" style="width:50%;" align="right">
				 <tr>  
					<td> <a href="{{url('agent-history')}}" class="mgbt-md-15 mgtp-10 font-semibold" > <b><i class="icon-list"></i>  Prevoius Code Purchase Listing</b> </a> </td>
				 </tr>      
				 </table>      
                     <br>
		<div class="table-responsive">
		 <form id="exampleValidation" action="{{url('code-purchase')}}" method="post" enctype="multipart/form-data" novalidate>
			@csrf
			<table id="firsttab" class="table table-bordered table-striped" style="width:50%;" align="center">
                <thead bgcolor="#A9A9A9">
                <tr>
                  <th>Plan</th>
                  <th>Value</th>
                  <th>No of voucher</th>
                  <th>Total</th> 
                </tr>
                </thead>
                <tbody>
				 
		   @foreach($vouchers as $data)
              <tr>
				<td>{{$data->name}}</td>
				<td>${{$data->amount}}</td>
				<td> <input style="width:150px;"  type="number" min="1" class="form-control numeric_feild voucher_no" name="voucher_no[{{$data->id}}]" id="voucher_no" value="{{old('voucher_no')}}" voucher_id="{{$data->id}}" amount="{{$data->amount}}" />
				
				</td>
				<td class="total" id="tr_total_{{$data->id}}"></td>
			  </tr>
			@endforeach	 
				
                 <tfoot>

			
				
				<tr>
					<th colspan="2" style="text-align: right;">Total</th>
					<th id="total_no"></th>
					<input type="hidden" class="total_no" name="total_no"   />
					<th id="total"></th>
					<input type="hidden" class="total" name="total"   />
				</tr>
				<tr>
					<th colspan="2" style="text-align: right;">Commission</th>
					<th  id="commission_val"></th>
					<th  id="commission"></th>
					<input type="hidden" class="commission" name="commission"   />
					<input type="hidden" class="commission_val" name="commission_val"   />
				</tr>
				<tr>
					<th colspan="2" style="text-align: right;">Grand Total</th>
					<th style="border-top: 2px solid #000;" ></th>
					<th style="border-top: 2px solid #000;" id="grand_total"></th>
					<input type="hidden" class="grand_total" name="grand_total"   />
					<div class="text-danger">{{$errors->first('grand_total')}}</div>
				</tr>
				<tr>
					<th colspan="2" style="text-align: right;">Payment Method</th>
					<th style="border-top: 2px solid #000;" colspan="2" >
					<div class="custom-control custom-radio custom-control-inline">
						<input type="radio" class="custom-control-input" name="payment_method" id="customRadio1" value="paypal" checked>
						<label class="custom-control-label" for="customRadio1">Paypal</label>
					</div>
					<div class="custom-control custom-radio custom-control-inline">
						<input type="radio" class="custom-control-input" name="payment_method" id="customRadio2" value="stripe" >
						<label class="custom-control-label" for="customRadio2">Credit Card</label>
					</div>
					</th>
					
					<div class="text-danger">{{$errors->first('grand_total')}}</div>
				</tr>
					
				
				</tfoot>
                </tbody>
				
            </table>
			<div class="col-md-12">			
			<div class="col-md-4">	
			</div>			
			<button style="width:178px;" align="center" type="submit"  class="slide-btn login-btn submit_btn">Make Payment</button>			
			<button style="width:178px;background:red;" href="{{url()->current()}}" align="center" type="reset"  class="slide-btn login-btn reset">Cancel</button>			
			</div>
				<input type="hidden" name="commission_id" id="commission_id" value="" />
			</form>						
		</div>
                   
                      

                    </div>
                </div>
            </div>
        </div>
		
	<input type="hidden" name="user_id" id="user_id" value="@if(Auth::check()){{Auth::user()->id}}@else 0 @endif" />
	<input type="hidden" name="comm" id="comm" value="{{$comm}}" />
	<input type="hidden" name="comm_count" id="comm_count" value="{{$commissions_count}}" />

	
        <!-- End Number area -->	
		
		<!-- jquery latest version -->
		<script src="{{url('public/frontend/js/vendor/jquery-1.12.4.min.js')}}"></script>
		<script>
		function submit()
		{
			$("form").submit();
		}
		function get_commission(val)
		{
			var comm  = <?php echo json_encode($commissions); ?>;
			
			
			var comm_count  = $("#comm_count").val();
			
			for(i=0;i<comm_count;i++)
			{
				console.log("min_val >> "+comm[i].min_val);
				console.log("max_val >> "+comm[i].max_val);
				console.log("val >> "+val);
				console.log("i >> "+i);
				if(val >=comm[i].min_val && val < comm[i].max_val )
				{
					var result  =  comm[i].percentage;
					$("#commission_id").val(comm[i].id);
					return result;
				}
				
				
			}
			 
			
			//console.log("result >> "+result);
			//console.log(comm_count);
		}
		 //todate
		function get_total()
		{
			var total=0;
			$(".total").each(function(){
				var val = parseInt(myfloatval($(this).text()));
				
				if(isNaN(val))
					val = 0;
				console.log("val >>"+val);
				total += val;
			});
			$("#total").text("$"+total);
			$(".total").val(total);
			
			var total_no=0;
			$(".voucher_no").each(function(){
				var val = parseInt(myfloatval($(this).val()));
				if(isNaN(val))
					val = 0;
				total_no += val;
			});
			$("#total_no").text(total_no);
			$(".total_no").val(total_no);
			
			var commission = parseFloat(get_commission(total));
			if(isNaN(commission))
				commission = 0;
			
			var per =  (total * commission) / 100; 
			
			$("#commission_val").text(commission+"%");
			$(".commission_val").val(commission);
			$("#commission").text("-$"+per);
			$(".commission").val(per);
			console.log("Commission >> "+commission);
			grand_total();
		}
		function grand_total()
		{
			var total = parseFloat(myfloatval($("#total").text()));
			if(isNaN(total))
				total = 0;
			var commission = parseFloat(myfloatval($("#commission").text()));
			if(isNaN(commission))
				commission = 0;
			$("#grand_total").text("$"+(total - commission).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, '$1,'));
			$(".grand_total").val((total - commission));
		}
		function myfloatval(myString)
		{
			console.log("myString >> "+myString);
			myString = myString.toString().replace(/[^a-z0-9.\s]/gi, '').replace(/[_\s]/g, '-');
			console.log("myString >> "+myString);
			return parseFloat(myString);
		}
		$(document).ready(function(){
			console.log(myfloatval("$89.99"));
			$(".submit_btn").click(function(e){
				
				grand_total_val = parseFloat($(".grand_total").val());
				if(isNaN(grand_total_val))
				grand_total_val = 0;
				
				if(grand_total_val < 1)
				{
					e.preventDefault();
					console.log("grand_total_val >> "+grand_total_val);
				  bootbox.alert("Please select at least 1 code");
				}
				else{
					return true;
				}
			})
			  $("#exampleValidation").validate({
			validClass: "success",
			rules: {
				"voucher_no[]": {
					required: true
				},
					
			},
			messages: { 
            "voucher_no[]": "Please select at least 1 code."
			},
			highlight: function(element) {
				$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
			},
			success: function(element) {
				$(element).closest('.form-group').removeClass('has-error').addClass('has-success');
			},
		});
			$(".voucher_no").on("keyup change",function(){
				
				var val = parseInt($(this).val());
				var amount = parseInt($(this).attr('amount'));
				var id = ($(this).attr('voucher_id'));
				
				if(isNaN(val))
					val = 0;
				if(isNaN(amount))
					amount = 0;
				
				var total = val * amount;
				$("#tr_total_"+id).text("$"+total);
				
				get_total();
			});
			
			$(".reset").click(function(){
				href = $(this).attr('href');
				location.href = href;
				
			})
		})
		</script>
		
@endsection	